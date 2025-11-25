<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        return response()->json([
            'first_name' => $user->first_name,
            'infix' => $user->infix,
            'last_name' => $user->last_name,
            'address' => $user->address,
            'postal_code' => $user->postal_code,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }
}
