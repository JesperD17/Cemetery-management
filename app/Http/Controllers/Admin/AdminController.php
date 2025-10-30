<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Cemetery;
use App\Models\User;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $cemeteries = Cemetery::query()
            ->when($search, fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin', [
            'page' => 'Admin Overzicht',
            'search' => $search,
            'cemeteries' => $cemeteries,
        ]);
    }

    
    public function users()
    {
        return response()->json(User::orderBy('created_at', 'desc')->get());
    }

    
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Gebruiker niet gevonden.',
            ], 404);
        }

        try {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gebruiker succesvol verwijderd.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verwijderen mislukt: ' . $e->getMessage(),
            ], 500);
        }
    }
}
