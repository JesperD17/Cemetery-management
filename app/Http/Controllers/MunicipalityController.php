<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipalityController extends Controller
{
    public function show(Request $request) 
    {
        $rightsHolders = DB::table('municipalities')->get();
        return response()->json($rightsHolders);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::table('municipalities')
            ->where('id', $id)
            ->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
            ]);

        return response()->json(['message' => 'Municipality updated successfully']);
    }
}
