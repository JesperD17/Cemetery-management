<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\GravesController;

class CemeteriesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax() && !$request->expectsJson()) {
            return redirect('/');
        }

        $userRoleID = $request->user()->role_id;
        $dbRole = DB::table('roles')->where('id', $userRoleID)->first();
        
        $gravesController = new GravesController();
        $graves = $gravesController->fetchByUser($request->user()->id);

        if ($dbRole && in_array($dbRole->name, ['super admin', 'admin', 'beheerder'])) {
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

    public function id(Request $request)
    {
        $id = $request->query('id');

        $cemetery = DB::table('cemeteries')->where('id', $id)->first();
        
        return response()->json($cemetery);
    }

    public function updateCemetery($id)
    {
        $data = request()->only([
            'name',
            'address',
            'zip_code',
            'city',
            'phone_number',
            'email',
            'description',
        ]);

        DB::table('cemeteries')->where('id', $id)->update($data);

        return response()->json(['message' => 'Cemetery updated successfully']);
    }
}
