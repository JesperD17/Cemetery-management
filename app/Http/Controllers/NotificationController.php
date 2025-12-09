<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Niet ingelogd'], 401);
        }

        // Haal alle graven op (inclusief grave_number, start_date, end_date)
        $graven = DB::table('graves')
            ->select('id', 'grave_number', 'start_date', 'end_date')
            ->get();

        $meldingen = [];
        $vandaag = Carbon::today();

        foreach ($graven as $graf) {
            if (!$graf->end_date) {
                continue;
            }

            $eindDatum = Carbon::parse($graf->end_date);
            $dagenTotEinde = $vandaag->diffInDays($eindDatum, false);

            if ($dagenTotEinde < 0) {
                $meldingen[] = [
                    'title' => 'Graf ' . $graf->grave_number,
                    'message' => 'De rechten van dit graf zijn verlopen op ' . $eindDatum->format('d-m-Y') . '.',
                    'type' => 'expired',
                ];
            } elseif ($dagenTotEinde <= 30) {
                $meldingen[] = [
                    'title' => 'Graf ' . $graf->grave_number,
                    'message' => 'De rechten van dit graf verlopen binnen ' . $dagenTotEinde . ' dagen (op ' . $eindDatum->format('d-m-Y') . ').',
                    'type' => 'warning',
                ];
            }
        }

        return response()->json($meldingen);
    }
}
