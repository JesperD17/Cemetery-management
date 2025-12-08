<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GravesController extends Controller
{
    public function index()
    {
        return response()->json($this->fetchByUser(auth()->id()));
    }

    public function fetchByUser($userId)
    {
        $user = DB::table('users')->where('id', $userId)->first();
        $roleName = null;
        if ($user) {
            if (isset($user->role_id)) {
                $dbRole = DB::table('roles')->where('id', $user->role_id)->first();
                $roleName = $dbRole->name ?? null;
            } else {
                $dbRole = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $userId)
                ->select('roles.name')
                ->first();
                $roleName = $dbRole->name ?? null;
            }
        }
        
        $cemeteryID = request()->query('cemeteryID');
        
        if (in_array(strtolower($roleName ?? ''), ['admin', 'super admin', 'editor'])) {
            $query = DB::table('graves as G')
                ->select(
                    'G.id AS grave_id',
                    'G.cemetery_id',
                    'G.latitude',
                    'G.longitude',
                    'G.image_hash_url',
                    'G.grave_number',
                    'G.status_id',
                    'G.description',
                    'G.start_date',
                    'G.end_date'
                );

            if ($cemeteryID) {
                $query->where('G.cemetery_id', $cemeteryID);
            }
            return $query->get();
        }

        $query = DB::table('graves as G')
            ->leftJoin('grave_users as GU', 'G.id', '=', 'GU.grave_id')
            ->leftJoin('users as U', 'U.id', '=', 'GU.user_id')
            ->select(
                'G.cemetery_id',
                'G.latitude',
                'G.longitude',
                'G.image_hash_url',
                'G.grave_number',
                'G.status_id',
                'G.description',
                'G.start_date',
                'G.end_date',
                'U.first_name',
                'U.infix',
                'U.last_name'
            );

        $query->where('U.id', $userId);

        if ($cemeteryID) {
            $query->where('G.cemetery_id', $cemeteryID);
        }
        $graves = $query->get();

        return $graves;
    }
}
