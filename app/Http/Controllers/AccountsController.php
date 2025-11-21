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
}