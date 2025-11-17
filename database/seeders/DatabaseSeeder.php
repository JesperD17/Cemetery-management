<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use App\Models\Cemeteries;
use App\Models\Graves;
use App\Models\Deceased;
use App\Models\GraveOfDeceased;
use App\Models\GraveUsers;
use App\Models\Municipalities;
use App\Models\GraveStatuses;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Roles::create(['name' => 'user']);
        Roles::create(['name' => 'editor']);
        Roles::create(['name' => 'admin']);

        // Municipalities
        Municipalities::create(['name' => 'Zwolle']);
        Municipalities::create(['name' => 'Kampen']);

        // Grave statuses
        GraveStatuses::create(['name' => 'available']);
        GraveStatuses::create(['name' => 'occupied']);

        // Cemeteries
        Cemeteries::create([
            'name' => 'Hakkenberg Uitvaartzorg BV',
            'municipality_id' => 1,
            'city' => 'Zwolle',
            'address' => 'Straat 1',
            'zip_code' => '8000AA',
            'image_hash_url' => 'c1.jpg',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Kranenburg',
            'municipality_id' => 1,
            'city' => 'Zwolle',
            'address' => 'Straat 2',
            'zip_code' => '8001BB',
            'image_hash_url' => 'c2.jpg',
        ]);

        // Users (test)
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'role_id' => 1,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Editor',
            'last_name' => 'User',
            'email' => 'editor@example.com',
            'role_id' => 2,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'role_id' => 3,
            'password_hash' => Hash::make('password'),
        ]);

        // Graves
        Graves::create([
            'cemetery_id' => 1,
            'latitude' => 52456800,
            'longitude' => 6058517,
            'image_hash_url' => 'g1.jpg',
            'grave_number' => 1,
            'status_id' => 1,
            'description' => 'Front row grave',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(10)->toDateString(),
        ]);

        // Deceased and linking
        Deceased::create([
            'first_name' => 'Jan',
            'infix' => 'de',
            'last_name' => 'Vries',
            'date_of_birth' => '1950-01-01',
            'date_of_death' => '2020-01-01',
        ]);

        GraveOfDeceased::create([
            'deceased_id' => 1,
            'grave_id' => 1,
        ]);

        // Link a user to the grave
        GraveUsers::create([
            'grave_id' => 1,
            'user_id' => 1,
        ]);
    }
}
