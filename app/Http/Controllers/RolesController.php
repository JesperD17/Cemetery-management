<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        // $roles = DB::table('roles')->get();
        // return response()->json($roles);

        $role = $request->user()?->load('role');
        $mapping = [
        'super admin' => ['admin', 'beheerder', 'rechthebbende'],
        'admin' => ['beheerder', 'rechthebbende'],
        'beheerder' => ['rechthebbende'],
        ];

        $allowedRoles = $mapping[$role->role->name] ?? [];
        
        $roles = DB::table('roles')
            ->whereIn('name', $allowedRoles)
            ->get();

        return response()->json($roles);
    }
}
