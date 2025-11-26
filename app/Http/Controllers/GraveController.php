<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Graves;

class GraveController extends Controller
{
    // Alle graven van ingelogde gebruiker
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Niet ingelogd'], 401);
        }

        $graven = Graves::with(['cemetery', 'graveStatus', 'deceased'])
            ->whereHas('graveUsers', fn($q) => $q->where('user_id', $user->id))
            ->get();

        return response()->json($graven);
    }

    // Eén specifiek graf
    public function show($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Niet ingelogd'], 401);
        }

        $graf = Graves::with(['cemetery', 'graveStatus', 'deceased'])
            ->where('id', $id)
            ->whereHas('graveUsers', fn($q) => $q->where('user_id', $user->id))
            ->first();

        if (!$graf) {
            return response()->json(['error' => 'Graf niet gevonden'], 404);
        }

        return response()->json($graf);
    }
}
