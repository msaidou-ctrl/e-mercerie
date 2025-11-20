<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MerceriesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = User::where('role', 'mercerie')
            ->whereHas('merchantSupplies')
            ->with(['cityModel', 'quarter'])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(business_name) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $merceries = $query->paginate(12)->withQueryString();

        return view('admin.merceries.index', compact('merceries', 'search'));
    }
}
