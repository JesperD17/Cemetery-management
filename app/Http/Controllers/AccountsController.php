<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    // Grabs the accounts data based on the role of the user making the request
    public function index(Request $request)
    {
        $role = $request->user()?->load('role');
        $mapping = [
        'super admin' => ['admin', 'beheerder', 'rechthebbende'],
        'admin' => ['beheerder', 'rechthebbende'],
        'beheerder' => ['rechthebbende'],
        ];

        $allowedRoles = $mapping[$role->role->name] ?? [];
        
        $accounts = User::whereHas('role', function ($query) use ($allowedRoles) {
            $query->whereIn('name', $allowedRoles);
        })->with('role')->get();

        return response()->json($accounts);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'infix' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'Account bijgewerkt']);
    }
}