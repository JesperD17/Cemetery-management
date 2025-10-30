<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use App\Models\Permissions;
use App\Models\Cemeteries;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Standard roles
        Roles::create([
            'name' => 'user',
            'permissionID' => 1,
        ]);

        Roles::create([
            'name' => 'editor',
            'permissionID' => 2,
        ]);

        Roles::create([
            'name' => 'admin',
            'permissionID' => 3,
        ]);

        Roles::create([
            'name' => 'super admin',
            'permissionID' => 4,
        ]);

        // Test users - remove in production
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => 1,
        ]);
    
        User::factory()->create([
            'name' => 'editor User',
            'email' => 'editor@example.com',
            'role_id' => 2,
        ]);
    
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => 3,
        ]);
    
        User::factory()->create([
            'name' => 'Super Admin User',
            'email' => 'admin2@example.com',
            'role_id' => 4,
        ]);

        // Standard roles
        // example
        Permissions::create(['name' => 'read']);
        Permissions::create(['name' => 'read, write, destroy']);
        
        // example cemeteries
        Cemeteries::create([
            'name' => 'Hakkenberg Uitvaartzorg BV',
            'municipality' => 'Zwolle',
            'latitude' => '52.456800',
            'longitude' => '6.058517',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Kranenburg',
            'municipality' => 'Zwolle',
            'latitude' => '52.531279',
            'longitude' => '6.129569',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats Joodse Gemeente Zwolle',
            'municipality' => 'Zwolle',
            'latitude' => '52.511279',
            'longitude' => '6.099569',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats De Vijfhoek',
            'municipality' => 'Zwolle',
            'latitude' => '52.450279',
            'longitude' => '5.9085691',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats De Vijfhoek2',
            'municipality' => 'Zwolle',
            'latitude' => '52.45110279',
            'longitude' => '5.9085169',
        ]);

        Cemeteries::create([
            'name' => 'Bovenbroek',
            'municipality' => 'Kampen',
            'latitude' => '52.541279',
            'longitude' => '5.912260',
        ]);

        Cemeteries::create([
            'name' => 'Eijgelaar Gedenken - Grafmonumenten & Grafstenen',
            'municipality' => 'Kampen',
            'latitude' => '52.562103',
            'longitude' => '5.875372',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats De Landerijen',
            'municipality' => 'Kampen',
            'latitude' => '52.45021179',
            'longitude' => '5.9018569',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats IJsselmuiden',
            'municipality' => 'Kampen',
            'latitude' => '52.571279',
            'longitude' => '5.902569',
        ]);

        Cemeteries::create([
            'name' => 'Begraafplaats De Landerijen2',
            'municipality' => 'Kampen',
            'latitude' => '52.4510279',
            'longitude' => '5.908569',
        ]);
    }
}
