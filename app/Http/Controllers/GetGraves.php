<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetGraves extends Controller
{
    // SELECT G.latitude, G.longitude, G.image_url, G.number, G.costs, G.type, G.term, RH.first_name, RH.infix, RH.last_name
    // FROM `graves` G
    // LEFT JOIN `grave_agreements` GA ON G.id = GA.grave_id
    // LEFT JOIN `rights_holders` RH ON RH.id = GA.rights_holder_id
    // WhHERE BH.id = 1;
    public function index()
    {
        $graves = DB::table('graves as G')
            ->leftJoin('grave_agreements as GA', 'G.id', '=', 'GA.grave_id')
            ->leftJoin('rights_holders as RH', 'RH.id', '=', 'GA.rights_holder_id')
            ->leftJoin('rights_holder_users as RHU', 'RHU.rights_holder_id', '=', 'RH.id')
            ->leftJoin('users as U', 'U.id', '=', 'RHU.user_id')
            ->select(
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
            )
            ->where('RH.id', auth()->user()->id)
            ->get();

        return response()->json($graves);
    }
}
