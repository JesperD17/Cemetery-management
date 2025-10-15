<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Begraafplaats;
use App\Models\User; // ✅ nodig voor het verwijderen van gebruikers

class AdminController extends Controller
{
    /**
     * Toon het adminoverzicht met begraafplaatsen.
     */
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

    /**
     * ✅ Haal alle gebruikers op (voor je Svelte frontend).
     */
    public function users()
    {
        return response()->json(User::all());
    }

    /**
     * ✅ Verwijder een gebruiker uit de database.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Gebruiker niet gevonden.'
            ], 404);
        }

        try {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gebruiker succesvol verwijderd.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verwijderen mislukt: ' . $e->getMessage()
            ], 500);
        }
    }
}
