<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;

class GraveController extends Controller
{
    public function index(Request $request)
    {
        dd($request);
        DB::table('graves')->insert([
            'cemetery_id' => $request->input('cemetery_id'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'image_hash_url' => $request->input('image_hash_url'),
            'grave_number' => $request->input('grave_number'),
            'status_id' => $request->input('status_id'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return response()->json(['message' => 'Graf succesvol aangemaakt.'], 201);
    }
}
