<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use App\Models\Permissions;
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
        // Permissions
        $read = Permissions::create(['name' => 'read']);
        $write = Permissions::create(['name' => 'write']);
        $admin = Permissions::create(['name' => 'admin']);

        // Roles (link to permissions)
        Roles::create(['name' => 'user', 'permission_id' => $read->id]);
        Roles::create(['name' => 'editor', 'permission_id' => $write->id]);
        Roles::create(['name' => 'admin', 'permission_id' => $admin->id]);

        // Municipalities
        $zwolle = Municipalities::create(['name' => 'Zwolle']);
        $kampen = Municipalities::create(['name' => 'Kampen']);

        // Grave statuses
        $available = GraveStatuses::create(['name' => 'available']);
        $occupied = GraveStatuses::create(['name' => 'occupied']);

        // Cemeteries
        $cem1 = Cemeteries::create([
            'name' => 'Hakkenberg Uitvaartzorg BV',
            'municipality_id' => $zwolle->id,
            'city' => 'Zwolle',
            'address' => 'Straat 1',
            'zip_code' => '8000AA',
            'image_hash_url' => 'c1.jpg',
        ]);

        $cem2 = Cemeteries::create([
            'name' => 'Begraafplaats Kranenburg',
            'municipality_id' => $zwolle->id,
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
        $grave1 = Graves::create([
            'cemetery_id' => $cem1->id,
            'latitude' => 52456800,
            'longitude' => 6058517,
            'image_hash_url' => 'g1.jpg',
            'grave_number' => 1,
            'status_id' => $available->id,
            'description' => 'Front row grave',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(10)->toDateString(),
        ]);

        // Deceased and linking
        $dec1 = Deceased::create([
            'first_name' => 'Jan',
            'infix' => 'de',
            'last_name' => 'Vries',
            'date_of_birth' => '1950-01-01',
            'date_of_death' => '2020-01-01',
        ]);

        GraveOfDeceased::create([
            'deceased_id' => $dec1->id,
            'grave_id' => $grave1->id,
        ]);

        // Link a user to the grave
        GraveUsers::create([
            'grave_id' => $grave1->id,
            'user_id' => 1,
        ]);
    }
}
