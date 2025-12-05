<?php

namespace Database\Seeders;

use App\Models\Municipalities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MunicipalitySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Municipalities::create(['name' => 'Zwolle']);
        Municipalities::create(['name' => 'Kampen']);
        Municipalities::create(['name' => 'Utrecht']);
        Municipalities::create(['name' => 'Deventer']);
        Municipalities::create(['name' => 'Lelystad']);
        Municipalities::create(['name' => 'Almere']);
        Municipalities::create(['name' => 'Amsterdam']);
        Municipalities::create(['name' => 'Rotterdam']);
    }
}