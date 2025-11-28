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
            'first_name'   => $user->first_name,
            'infix'        => $user->infix,
            'last_name'    => $user->last_name,
            'address'      => $user->address,
            'zip_code'     => $user->zip_code,
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'infix'        => 'nullable|string|max:255',
            'last_name'    => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'zip_code'     => 'required|string|max:20',
            'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profiel succesvol geüpdatet',
            'user'    => $user
        ]);
    }
}
