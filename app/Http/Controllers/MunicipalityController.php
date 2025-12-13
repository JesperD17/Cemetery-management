<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MunicipalityController extends Controller
{
    public function show(Request $request) 
    {
        $rightsHolders = DB::table('municipalities')->get();
        return response()->json($rightsHolders);
    }

    public function update(Request $request, $id)
    {
        try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        } catch (ValidationException $e) {
            return back(303)->withErrors($e->errors());
        }

        DB::table('municipalities')
            ->where('id', $id)
            ->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'updated_at' => now(),
            ]);

        return response()->json(['message' => 'Municipality updated successfully']);
    }

    public function store(Request $request)
    {
        try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);
        } catch (ValidationException $e) {
            return back(303)->withErrors($e->errors());
        }

        DB::table('municipalities')->insert([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Municipality created successfully']);

    }
}
