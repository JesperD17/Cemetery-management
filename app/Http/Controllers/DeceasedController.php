<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DeceasedController extends Controller
{
    protected $graveDeceasedController;

    public function __construct(GraveDeceasedController $graveDeceasedController)
    {
        $this->graveDeceasedController = $graveDeceasedController;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'infix' => 'nullable|string|max:50',
                'last_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'date_of_death' => 'required|date',
                'description' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return back(303)->withErrors($e->errors());
        }

        try {
            DB::table('deceased')->insert([
                'first_name' => $validated['first_name'],
                'infix' => $validated['infix'] ?? null,
                'last_name' => $validated['last_name'],
                'date_of_birth' => $validated['date_of_birth'],
                'date_of_death' => $validated['date_of_death'],
                'description' => $validated['description'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->graveDeceasedController->store(new Request([
                'grave_id' => $request->query('grave_id'),
                'deceased_id' => DB::getPdo()->lastInsertId(),
            ]));
        } catch (QueryException $e) {
            return back()->with('error', 'Er is een fout opgetreden bij het aanmaken van de overledene.');
        }
        return back()->with('success', 'Overledene succesvol toegevoegd.');
    }
}
