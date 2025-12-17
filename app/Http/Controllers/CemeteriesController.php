<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\GravesController;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CemeteriesController extends Controller
{
    public function index(Request $request)
    {
        try {
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
        } catch (QueryException $e) {
            return response()->json(['error' => 'Er is een fout opgetreden bij het ophalen van de begraafplaatsen.', $e->getMessage()], 500);
        }
    }

    public function id(Request $request)
    {
        try {
            $id = $request->query('id');

            if (!$id) {
                return response()->json(['error' => 'Cemetery ID is required'], 400);
            }

            $cemetery = DB::table('cemeteries')->where('id', $id)->first();
            
            if (!$cemetery) {
                return response()->json(['error' => 'Cemetery not found'], 404);
            }
            
            return response()->json($cemetery);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Er is een fout opgetreden bij het ophalen van de begraafplaats.'], 500);
        }
    }

    public function updateCemetery(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'grave_types' => 'nullable|string|max:50',
                'grave_sorts' => 'nullable|string|max:50',
                'address' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:20',
                'city' => 'nullable|string|max:100',
                'phone_number' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'description' => 'nullable|string',
            ]);
            DB::table('cemeteries')->where('id', $id)->update($data);
            return response()->json(['message' => 'Cemetery updated successfully']);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Er is een fout opgetreden bij het toevoegen van de begraafplaats.', $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:cemeteries,name|string|max:255',
                'municipality_id' => 'required|integer',
                'grave_types' => 'nullable|string|max:50',
                'grave_sorts' => 'nullable|string|max:50',
                'city' => 'required|string|unique:cemeteries,city|max:100',
                'address' => 'required|string|unique:cemeteries,address|max:255',
                'zip_code' => 'required|string|unique:cemeteries,zip_code|max:20',
                'image_hash_url' => 'required|unique:cemeteries,image_hash_url|string|max:5120',
                'description' => 'nullable|string',
            ]);
            
            $data = [
                'name' => $validated['name'],
                'municipality_id' => $validated['municipality_id'],
                'grave_types' => $validated['grave_types'],
                'grave_sorts' => $validated['grave_sorts'],
                'city' => $validated['city'],
                'address' => $validated['address'],
                'zip_code' => $validated['zip_code'],
                'image_hash_url' => $validated['image_hash_url'],
                'description' => $validated['description'] ?? null,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];

            $cemeteryId = DB::table('cemeteries')->insertGetId($data);

            return redirect()->back()->
            with('success', 'Begraafplaats succesvol toegevoegd')->
            with('id', $cemeteryId)->
            with('success3', 'Begraafplaats succesvol toegevoegd');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (QueryException $e) {
            return back()->withErrors(['error' => 'Er is een fout opgetreden bij het toevoegen van de begraafplaats.', $e->getMessage()]);
        }
    }
}
