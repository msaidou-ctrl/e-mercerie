<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Quarter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        
        if ($user->isMercerie()) {
            return redirect()->route('merceries.profile.edit');
        }

        $cities = City::orderBy('name')->get();
        $quarters = collect();
        
        if ($user->city_id) {
            $quarters = Quarter::where('city_id', $user->city_id)->orderBy('name')->get();
        }

        return view('couturier.profile.edit', compact('user', 'cities', 'quarters'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Validation pour couturier
        $rules = [
            'name' => 'required|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'quarter_id' => 'nullable|exists:quarters,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $data = $request->validate($rules);

        // Vérifier la cohérence ville/quartier
        if (!empty($data['city_id']) && !empty($data['quarter_id'])) {
            $belongs = Quarter::where('id', $data['quarter_id'])
                            ->where('city_id', $data['city_id'])
                            ->exists();
            if (!$belongs) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Le quartier sélectionné n\'appartient pas à la ville choisie.');
            }
        }

        // Gérer l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        // Mettre à jour l'utilisateur
        $user->update([
            'name' => $data['name'],
            'city_id' => $data['city_id'] ?? null,
            'quarter_id' => $data['quarter_id'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'avatar' => $data['avatar'] ?? $user->avatar,
        ]);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}