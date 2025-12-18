<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders (to keep this file clean)
        $this->call([
            RoleSeeder::class,
            GraveStatusSeeder::class,
            MunicipalitySeeder::class,
            CemeterySeeder::class,
            GraveSeeder::class,
            DeceasedSeeder::class,
            UserSeeder::class,
            GraveOfDeceasedSeeder::class,
            GraveUsersSeeder::class,
        ]);
    }
}