<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypesSortsController extends Controller
{
    public function index($cemeteryID)
    {
        $cemetery = DB::table('cemeteries')->where('id', $cemeteryID)->first();

        if (!$cemetery) {
            return response()->json(['error' => 'Cemetery not found'], 404);
        }

        $typesSplit = array_map('trim', explode(',', $cemetery->grave_types));
        $sortsSplit = array_map('trim', explode(',', $cemetery->grave_sorts));

        $json = [
            'types' => $this->formatItems($typesSplit),
            'sorts' => $this->formatItems($sortsSplit),
        ];
        return response()->json($json);
    }

    private function formatItems($items)
    {
        return array_map(fn($item) => ['name' => $item], $items);
    }
}
