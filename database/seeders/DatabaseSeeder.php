<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\GraveStatuses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles (link to permissions)
        Roles::create(['name' => 'rechthebbende']);
        Roles::create(['name' => 'beheerder']);
        Roles::create(['name' => 'admin']);
        Roles::create(['name' => 'super admin']);
        
        // Grave statuses
        GraveStatuses::create(['name' => 'available']);
        GraveStatuses::create(['name' => 'occupied']);

        // Call other seeders (to keep this file clean)
        $this->call([
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