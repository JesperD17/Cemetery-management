<?php

namespace Database\Seeders;

use App\Models\GraveUsers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GraveUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        GraveUsers::create([
            'grave_id' => 1,
            'user_id' => 1,
        ]);

        GraveUsers::create([
            'grave_id' => 2,
            'user_id' => 2,
        ]);

        GraveUsers::create([
            'grave_id' => 3,
            'user_id' => 3,
        ]);

        GraveUsers::create([
            'grave_id' => 4,
            'user_id' => 4,
        ]);

        GraveUsers::create([
            'grave_id' => 5,
            'user_id' => 5,
        ]);

        GraveUsers::create([
            'grave_id' => 6,
            'user_id' => 6,
        ]);

        GraveUsers::create([
            'grave_id' => 7,
            'user_id' => 7,
        ]);

        GraveUsers::create([
            'grave_id' => 8,
            'user_id' => 8,
        ]);
    }
}