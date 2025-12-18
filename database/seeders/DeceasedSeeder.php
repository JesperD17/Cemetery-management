<?php

namespace Database\Seeders;

use App\Models\Deceased;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeceasedSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Deceased::create([
            'first_name' => 'Jan',
            'infix' => 'de',
            'last_name' => 'Vries',
            'date_of_birth' => '1950-01-01',
            'date_of_death' => '2020-01-01',
        ]);

        Deceased::create([
            'first_name' => 'Piet',
            'infix' => 'van',
            'last_name' => 'Dijk',
            'date_of_birth' => '1960-02-02',
            'date_of_death' => '2021-02-02',
        ]);

        Deceased::create([
            'first_name' => 'Klaas',
            'infix' => '',
            'last_name' => 'Jansen',
            'date_of_birth' => '1970-03-03',
            'date_of_death' => '2022-03-03',
        ]);

        Deceased::create([
            'first_name' => 'Marie',
            'infix' => 'ter',
            'last_name' => 'Berg',
            'date_of_birth' => '1980-04-04',
            'date_of_death' => '2023-04-04',
        ]);

        Deceased::create([
            'first_name' => 'Anna',
            'infix' => 'van de',
            'last_name' => 'Heuvel',
            'date_of_birth' => '1990-05-05',
            'date_of_death' => '2024-05-05',
        ]);

        Deceased::create([
            'first_name' => 'Kees',
            'infix' => '',
            'last_name' => 'Smits',
            'date_of_birth' => '1945-06-06',
            'date_of_death' => '2019-06-06',
        ]);

        Deceased::create([
            'first_name' => 'Els',
            'infix' => 'de',
            'last_name' => 'Wit',
            'date_of_birth' => '1955-07-07',
            'date_of_death' => '2018-07-07',
        ]);

        Deceased::create([
            'first_name' => 'Henk',
            'infix' => 'van',
            'last_name' => 'Leeuw',
            'date_of_birth' => '1965-08-08',
            'date_of_death' => '2017-08-08',
        ]);
    }
}