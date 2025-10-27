<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetCityName extends Controller
{
    public function index(Request $request)
    {
        $latitude = $request->query('lat');
        $longitude = $request->query('lon');

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Coordinates are required'], 400);
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Begraafplaats-beheer',
            ])->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Failed to fetch data from API'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
