<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Supply;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MerchantController extends Controller
{
    // Liste de toutes les merceries
    public function index(Request $request)
    {
        $search = $request->input('search');

    $perPage = 12;

        $merceries = User::where('role', 'mercerie')
            ->where('id', '!=', auth()->id()) // exclure la mercerie connectée
            ->whereHas('merchantSupplies')   // au moins une fourniture
            ->when($search, function ($query, $search) {
                                $query->where(function ($q) use ($search) {
                                            $q->where('business_name', 'like', "%{$search}%")
                                            ->orWhere('email', 'like', "%{$search}%")
                                            ->orWhere('phone', 'like', "%{$search}%");

                                        // Search by related city name
                    $q->orWhereHas('cityModel', function ($qc) use ($search) {
                        $qc->where('name', 'like', "%{$search}%");
                    });

                    // Search by related quarter name
                    $q->orWhereHas('quarter', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%{$search}%");
                    });
                                });
            })
            ->with(['merchantSupplies','cityModel','quarter'])
            ->paginate($perPage)
            ->withQueryString();

        return view('couturier.merceries.index', compact('merceries', 'search'));
    }

    /**
     * Public landing page showing merceries with supplies
     */
    public function landing(Request $request)
    {
        $perPageMerceries = 12; // kept for supplies pagination

        // Default landing: show the 6 latest merceries that have at least one supply
        $merceries = User::where('role', 'mercerie')
            ->whereHas('merchantSupplies')
            ->when(auth()->check(), function ($q) {
                $q->where('id', '!=', auth()->id());
            })
            ->with(['merchantSupplies','cityModel','quarter'])
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // Total count of merceries with supplies (used to decide whether to show "Voir plus")
        $totalMerceries = User::where('role', 'mercerie')->whereHas('merchantSupplies')->count();

        // Also pass available supplies so landing can show selection form
        $perPage = 10;
        $supplies = Supply::orderBy('name')->paginate($perPage)->withQueryString();
        return view('landing', compact('merceries', 'supplies', 'totalMerceries'));
    }

    public function searchAjax(Request $request)
    {
        $query = $request->input('search');

        $merceries = User::where('role', 'mercerie')
            // Only merceries (role) that have supplies
            ->whereHas('merchantSupplies')
            // Exclude currently authenticated merchant if present
            ->when(auth()->check(), function ($q) {
                $q->where('id', '!=', auth()->id());
            })
            // Apply search filter when provided
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('business_name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%")
                            ->orWhere('phone', 'like', "%{$query}%");

                        // Search by related city name
                        $sub->orWhereHas('cityModel', function ($qc) use ($query) {
                            $qc->where('name', 'like', "%{$query}%");
                        });

                        // Search by related quarter name
                        $sub->orWhereHas('quarter', function ($qq) use ($query) {
                            $qq->where('name', 'like', "%{$query}%");
                        });
                });
            })
            ->with(['merchantSupplies','cityModel','quarter'])
            ->get();
        // Map response to include avatar_url and a short description
        $payload = $merceries->map(function ($m) {
            return [
                'id' => $m->id,
                'name' => $m->display_business_name,
                'city' => $m->city,
                'quarter' => $m->quarter?->name ?? null,
                'phone' => $m->phone,
                'avatar_url' => $m->avatar_url ?? asset('images/defaults/mercerie-avatar.png'),
                'description' => $m->address ? 
                    (strlen($m->address) > 80 ? substr($m->address, 0, 77) . '...' : $m->address) : '',
                'has_supplies' => $m->merchantSupplies->isNotEmpty(),
            ];
        });

        return response()->json($payload);
    }




    // Détails d'une mercerie + fournitures disponibles
    public function show($id)
    {
        $mercerie = User::where('role', 'mercerie')->with('merchantSupplies.supply')->findOrFail($id);
        return view('couturier.merceries.show', compact('mercerie'));
    }

    public function edit()
    {
        $user = auth()->user();
        // Load cities and (optionally) quarters for the user's city to prepopulate selects
        $cities = \App\Models\City::orderBy('name')->get();
        $quarters = collect();
        if (! empty($user->city_id)) {
            $quarters = \App\Models\Quarter::where('city_id', $user->city_id)->orderBy('name')->get();
        }

        // Serve role-specific edit view if exists, else fall back to a generic profile edit
        if ($user->isMercerie()) {
            return view('merceries.profile.edit', ['mercerie' => $user, 'cities' => $cities, 'quarters' => $quarters]);
        }

        // Couturier view
        return view('couturier.profile.edit', ['user' => $user, 'cities' => $cities, 'quarters' => $quarters]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Role-specific validation: merceries must provide city/quarter; couturiers may not
        if ($user->isMercerie()) {
            $rules = [
                'business_name' => 'required|string|max:255',
                'city_id' => 'required|exists:cities,id',
                'quarter_id' => 'required|exists:quarters,id',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        } else {
            // Couturier or other roles
            $rules = [
                'name' => 'required|string|max:255',
                'city_id' => 'nullable|exists:cities,id',
                'quarter_id' => 'nullable|exists:quarters,id',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

        $data = $request->validate($rules);

        // If merchant provided both city and quarter, ensure relation integrity
        if ($user->isMercerie() && !empty($data['city_id']) && !empty($data['quarter_id'])) {
            $belongs = \App\Models\Quarter::where('id', $data['quarter_id'])->where('city_id', $data['city_id'])->exists();
            if (! $belongs) {
                return redirect()->back()->withInput()->with('error', 'Le quartier sélectionné n\'appartient pas à la ville choisie.');
            }
        }

        if ($request->hasFile('avatar')) {
            try {
                // Delete previous avatar file if present
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarFile = $request->file('avatar');
                $path = $avatarFile->store('avatars', 'public');
                $data['avatar'] = $path;
            } catch (\Throwable $e) {
                // Log detailed error for production debugging and continue without blocking the whole request
                $avatarFile = $avatarFile ?? null;
                Log::error('Failed to process avatar upload for user id ' . ($user->id ?? 'n/a') . ': ' . $e->getMessage(), [
                    'exception' => $e,
                    'user_id' => $user->id ?? null,
                    'file_info' => $avatarFile ? [
                        'originalName' => $avatarFile->getClientOriginalName(),
                        'size' => $avatarFile->getSize(),
                        'mime' => $avatarFile->getMimeType() ?? null,
                    ] : null,
                ]);

                // Remove avatar key so we don't overwrite existing avatar with null
                unset($data['avatar']);
                // Optionally flash a warning for the user (kept minimal in production)
                session()->flash('error', 'Impossible d\'uploader l\'avatar — veuillez réessayer plus tard.');
            }
        }

        // Map city_id/quarter_id to user's columns
        // Save merchant business name
        if ($user->isMercerie()) {
            $user->business_name = $data['business_name'] ?? $user->business_name;
        }
        $user->city_id = $data['city_id'] ?? null;
        $user->quarter_id = $data['quarter_id'] ?? null;
        $user->phone = $data['phone'] ?? $user->phone;
        $user->address = $data['address'] ?? $user->address;
        if (isset($data['avatar'])) {
            $user->avatar = $data['avatar'];
        }
        try {
            $user->save();
        } catch (\Throwable $e) {
            Log::error('Failed to save updated profile for user id ' . ($user->id ?? 'n/a') . ': ' . $e->getMessage(), ['exception' => $e, 'user_id' => $user->id ?? null]);
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour du profil.');
        }

        // Redirect depending on role
        if ($user->isMercerie()) {
            return redirect()->route('merchant.supplies.index')->with('success', 'Profil complété avec succès.');
        }

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

}
