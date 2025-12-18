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
}
