<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Cemeteries;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $cemeteries = Cemeteries::query()
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
        try {
            $deleted = DB::table('rights_holders')->where('id', $id)->delete();

            if ($deleted === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gebruiker niet gevonden in rights_holders.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gebruiker succesvol verwijderd uit rights_holders.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verwijderen mislukt: ' . $e->getMessage(),
            ], 500);
        }
    }
}
