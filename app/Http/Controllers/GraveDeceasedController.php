<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraveDeceasedController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'grave_id' => 'required|integer|exists:graves,id',
                'deceased_id' => 'required|integer|exists:deceased,id',
            ]);

            $graveId = $validated['grave_id'];
            $deceasedId = $validated['deceased_id'];

            DB::table('grave_of_deceased')->insert([
                'grave_id' => $graveId,
                'deceased_id' => $deceasedId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Overledene succesvol gekoppeld aan het graf.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back(303)->withErrors($e->errors());
        }
    }
}
