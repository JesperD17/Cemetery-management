<?php

namespace App\Http\Controllers;

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

        $today = Carbon::today();

        $gravesQuery = DB::table('graves')
            ->select('id', 'grave_number', 'start_date', 'end_date');

        if ($user->role->name === 'rechthebbende') {
            
            $gravesQuery->where('user_id', $user->id);
        }

        $graves = $gravesQuery->get();

        $notifications = [];

        foreach ($graves as $grave) {
            if (!$grave->end_date) {
                continue;
            }

            $endDate = Carbon::parse($grave->end_date);
            $daysUntilEnd = $today->diffInDays($endDate, false);

            if ($daysUntilEnd < 0) {
                $notifications[] = [
                    'title'   => 'Graf ' . $grave->grave_number,
                    'message' => 'De rechten van dit graf zijn verlopen op ' . $endDate->format('d-m-Y') . '.',
                    'type'    => 'expired',
                ];
            } elseif ($daysUntilEnd <= 30) {
                $notifications[] = [
                    'title'   => 'Graf ' . $grave->grave_number,
                    'message' => 'De rechten van dit graf verlopen binnen ' . $daysUntilEnd . ' dagen (op ' . $endDate->format('d-m-Y') . ').',
                    'type'    => 'warning',
                ];
            }
        }
        return response()->json($notifications);
    }
}
