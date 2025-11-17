<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetCemeteries extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax() && !$request->expectsJson()) {
            return redirect('/');
        }

        $userRoleID = $request->user()->role_id;
        $dbRole = DB::table('roles')->where('id', $userRoleID)->first();
        
        $getGravesController = new GetGraves();
        $graves = $getGravesController->fetchByUser($request->user()->id);

        if ($dbRole && in_array($dbRole->name, ['admin', 'super admin', 'editor'])) {
            $cemeteries = DB::table('cemeteries')->get();
        } else {
            $cemeteryIds = $graves->pluck('cemetery_id')->unique()->filter()->values()->all();
            if (empty($cemeteryIds)) {
                $cemeteries = collect();
            } else {
                $cemeteries = DB::table('cemeteries')->whereIn('id', $cemeteryIds)->get();
            }
        }
        return response()->json($cemeteries);
    }
}
