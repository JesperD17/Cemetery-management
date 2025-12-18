<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GraveController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'cemetery_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'sort' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'image_hash_url' => 'required|string|max:5120',
            'grave_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('graves', 'grave_number')
                    ->where(fn ($query) => $query->where('cemetery_id', $request->input('cemetery_id'))),
            ],
            'status_id' => 'required|integer',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];

        $messages = [
            'grave_number.unique' => 'Dit grafnummer is al in gebruik.',
        ];

        $attributes = [
            'grave_number' => 'grafnummer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        try {
            DB::table('graves')->insert([
                'cemetery_id' => $validatedData['cemetery_id'],
                'type' => $validatedData['type'],
                'sort' => $validatedData['sort'],
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'image_hash_url' => $validatedData['image_hash_url'],
                'grave_number' => $validatedData['grave_number'],
                'status_id' => $validatedData['status_id'],
                'description' => $validatedData['description'] ?? null,
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (QueryException $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het opslaan van het graf.');
        }

        return back()->with('success', 'Graf succesvol aangemaakt.')->with('success2', 'Graf succesvol aangemaakt.');
    }

    public function id(Request $request)
    {
        $graveId = $request->query('id');

        if (!$graveId) {
            return response()->json(['error' => 'No grave ID provided'], 400);
        }

        $grave = DB::table('graves')
            ->where('id', $graveId)
            ->first();

        if (!$grave) {
            return response()->json(['error' => 'Grave not found'], 404);
        }

        return response()->json($grave);
    }
}
