<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetCementeries extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax() && !$request->expectsJson()) {
            return redirect('/');
        }

        $userRoleID = $request->user()->role_id;
        $dbRole = DB::table('roles')->where('id', $userRoleID)->first();
        $currentCity = $request->query('city');

        if ($dbRole && in_array($dbRole->name, ['admin', 'super admin', 'editor'])) {
            $cemeteries = DB::table('cemeteries')->get();
        } else {
            $cemeteries = DB::table('cemeteries')->where('municipality', 'LIKE', '%' . $currentCity . '%')->get();
        }
        return response()->json($cemeteries);
    }
}
