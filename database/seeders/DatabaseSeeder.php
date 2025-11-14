<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use App\Models\Permissions;
use App\Models\Cemeteries;
use App\Models\GraveAgreements;
use App\Models\Graves;
use App\Models\RightsHolders;
use App\Models\RightsHoldersUsers;
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
            'name' => 'rechthebbende',
            'permissionID' => 1,
        ]);

        Roles::create([
            'name' => 'beheerder',
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

        // Graves
        Graves::create([
            'cemetery_id' => 1,
            'latitude' => '52.456900',
            'longitude' => '6.058600',
            'image_url' => 'example.jpg',
            'number' => 'A1',
            'costs' => '5000',
            'type' => 'grave',
            'term' => '10 years',
        ]);

        Graves::create([
            'cemetery_id' => 1,
            'latitude' => '52.456850',
            'longitude' => '6.058550',
            'image_url' => 'example2.jpg',
            'number' => 'A2',
            'costs' => '6000',
            'type' => 'grave',
            'term' => '20 years',
        ]);

        Graves::create([
            'cemetery_id' => 2,
            'latitude' => '52.531300',
            'longitude' => '6.129600',
            'image_url' => 'example3.jpg',
            'number' => 'B1',
            'costs' => '5500',
            'type' => 'grave',
            'term' => '15 years',
        ]);
        
        // Rights Holders
        RightsHolders::create([ 
            'first_name' => 'Jan',
            'infix' => 'de',
            'last_name' => 'Vries',
            'address' => 'Dorpsstraat 1',
            'city' => 'Zwolle',
        ]);

        RightsHolders::create([
            'first_name' => 'Piet',
            'infix' => 'van',
            'last_name' => 'Dijk',
            'address' => 'Kerklaan 5',
            'city' => 'Kampen',
        ]);
        
        RightsHolders::create([
            'first_name' => 'Klaas',
            'infix' => '',
            'last_name' => 'Jansen',
            'address' => 'Schoolstraat 10',
            'city' => 'Zwolle',
        ]);

        // Agreements
        GraveAgreements::create([
            'grave_id' => 1,
            'rights_holder_id' => 1,
            'start_date' => '2020-01-01',
            'end_date' => '2030-01-01',
        ]);

        GraveAgreements::create([
            'grave_id' => 3,
            'rights_holder_id' => 1,
            'start_date' => '2021-01-01',
            'end_date' => '2030-12-01',
        ]);

        // Link user to rights holder
        RightsHoldersUsers::create([
            'rights_holder_id' => 1,
            'user_id' => 1,
        ]);
    }
}
