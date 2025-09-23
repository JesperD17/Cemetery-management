<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Begraafplaats;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $begraafplaatsen = Begraafplaats::query()
            ->when($search, fn($q) => $q
                ->where('naam', 'like', "%{$search}%")
                ->orWhere('locatie', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin', [
            'page' => 'Admin Overzicht',
            'search' => $search,
            'begraafplaatsen' => $begraafplaatsen,
        ]);
    }
}
