<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function profile(Request $request)
    {
        // Haal de huidige ingelogde gebruiker op
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        // Geef de gebruikersgegevens als JSON terug
        return response()->json($user);
    }
}
