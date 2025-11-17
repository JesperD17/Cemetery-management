<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetGraves extends Controller
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
                    'G.cemetery_id',
                    'G.latitude',
                    'G.longitude',
                    'G.image_url',
                    'G.number',
                    'G.costs',
                    'G.type',
                    'G.term'
                );

            if ($cemeteryID) {
                $query->where('G.cemetery_id', $cemeteryID);
            }

            return $query->get();
        }

        $query = DB::table('graves as G')
            ->leftJoin('grave_agreements as GA', 'G.id', '=', 'GA.grave_id')
            ->leftJoin('rights_holders as RH', 'RH.id', '=', 'GA.rights_holder_id')
            ->leftJoin('rights_holder_users as RHU', 'RHU.rights_holder_id', '=', 'RH.id')
            ->leftJoin('users as U', 'U.id', '=', 'RHU.user_id')
            ->select(
                'G.cemetery_id',
                'G.latitude',
                'G.longitude',
                'G.image_url',
                'G.number',
                'G.costs',
                'G.type',
                'G.term',
                'RH.first_name',
                'RH.infix',
                'RH.last_name'
            );

        $query->where('U.id', $userId);

        if ($cemeteryID) {
            $query->where('G.cemetery_id', $cemeteryID);
        }
        $graves = $query->get();

        return $graves;
    }
}
