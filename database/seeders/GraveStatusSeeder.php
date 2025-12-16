<?php

namespace Database\Seeders;

use App\Models\GraveStatuses;
use Illuminate\Database\Seeder;

class GraveStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GraveStatuses::create(['name' => 'vrij']);
        GraveStatuses::create(['name' => 'in gebruik']);
        GraveStatuses::create(['name' => 'wordt geruimd']);
        GraveStatuses::create(['name' => 'gereserveerd']);
        GraveStatuses::create(['name' => 'onbekend']);
    }
}
