<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckRoleController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax() && !$request->expectsJson()) {
            return redirect('/');
        }

        $userRoleID = $request->user()->role_id;
        $userRoleData = DB::table('roles')->where('id', $userRoleID)->first();

        return response()->json(['role_name' => $userRoleData->name]);
    }
}
