<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RightholderController extends Controller
{
    public function index()
    {
        try {
            $rightholders = DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', '=', 'rechthebbende')
                ->select(
                    'users.id',
                    'users.first_name',
                    'users.infix',
                    'users.last_name',
                    'users.phone_number',
                    'users.address',
                    'users.zip_code',
                    'users.email'
                )
                ->get();
            
            return response()->json($rightholders);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Unable to fetch rightholders'], 500);
        }
    }

    public function linkGrave(Request $request)
    {
        $validated = $request->validate([
            'rightholder_id' => 'required|integer|exists:users,id',
            'grave_id' => 'required|integer|exists:graves,id',
        ]);

        try {
            DB::table('grave_users')->insert([
                'grave_id' => $validated['grave_id'],
                'user_id' => $validated['rightholder_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'De rechthebbende is succesvol gekoppeld aan het graf.');
        } catch (QueryException $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het koppelen van de rechthebbende aan het graf.');
        }
    }
}
