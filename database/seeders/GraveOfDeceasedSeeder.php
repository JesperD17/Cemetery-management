<?php

namespace Database\Seeders;

use App\Models\GraveOfDeceased;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GraveOfDeceasedSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        GraveOfDeceased::create([
            'deceased_id' => 1,
            'grave_id' => 1,
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 2,
            'grave_id' => 2,
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 3,
            'grave_id' => 3,
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 4,
            'grave_id' => 4,
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 5,
            'grave_id' => 5,
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 6,
            'grave_id' => 6,
        ]);

        GRaveOfDeceased::create([
            'deceased_id' => 7,
            'grave_id' => 7,
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 8,
            'grave_id' => 8,
        ]);
    }
}