<?php

namespace Database\Seeders;

use App\Models\Graves;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GraveSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Graves::create([
            'cemetery_id' => 1,
            'latitude' => 52456800,
            'longitude' => 6058517,
            'image_hash_url' => 'g1.jpg',
            'grave_number' => 1,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(10)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 1,
            'latitude' => 52456810,
            'longitude' => 6058520,
            'image_hash_url' => 'g2.jpg',
            'grave_number' => 2,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(5)->toDateString(),
            'end_date' => now()->addYears(5)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 1,
            'latitude' => 52456900,
            'longitude' => 6058530,
            'image_hash_url' => 'g3.jpg',
            'grave_number' => 3,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(15)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 1,
            'latitude' => 52457000,
            'longitude' => 6058540,
            'image_hash_url' => 'g4.jpg',
            'grave_number' => 4,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(2)->toDateString(),
            'end_date' => now()->addYears(8)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 2,
            'latitude' => 52457100,
            'longitude' => 6058550,
            'image_hash_url' => 'g5.jpg',
            'grave_number' => 5,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(20)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 2,
            'latitude' => 52457200,
            'longitude' => 6058560,
            'image_hash_url' => 'g6.jpg',
            'grave_number' => 6,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(1)->toDateString(),
            'end_date' => now()->addYears(9)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 2,
            'latitude' => 52457300,
            'longitude' => 6058570,
            'image_hash_url' => 'g7.jpg',
            'grave_number' => 7,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(12)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 2,
            'latitude' => 52457400,
            'longitude' => 6058580,
            'image_hash_url' => 'g8.jpg',
            'grave_number' => 8,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(3)->toDateString(),
            'end_date' => now()->addYears(7)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 3,
            'latitude' => 52457500,
            'longitude' => 6058590,
            'image_hash_url' => 'g9.jpg',
            'grave_number' => 9,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(25)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 3,
            'latitude' => 52457600,
            'longitude' => 6058600,
            'image_hash_url' => 'g10.jpg',
            'grave_number' => 10,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(4)->toDateString(),
            'end_date' => now()->addYears(6)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 3,
            'latitude' => 52457700,
            'longitude' => 6058610,
            'image_hash_url' => 'g11.jpg',
            'grave_number' => 11,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(30)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 3,
            'latitude' => 52457800,
            'longitude' => 6058620,
            'image_hash_url' => 'g12.jpg',
            'grave_number' => 12,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(6)->toDateString(),
            'end_date' => now()->addYears(4)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 4,
            'latitude' => 52457900,
            'longitude' => 6058630,
            'image_hash_url' => 'g13.jpg',
            'grave_number' => 13,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(15)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 4,
            'latitude' => 52458000,
            'longitude' => 6058640,
            'image_hash_url' => 'g14.jpg',
            'grave_number' => 14,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(2)->toDateString(),
            'end_date' => now()->addYears(8)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 4,
            'latitude' => 52458100,
            'longitude' => 6058650,
            'image_hash_url' => 'g15.jpg',
            'grave_number' => 15,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(20)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 4,
            'latitude' => 52458200,
            'longitude' => 6058660,
            'image_hash_url' => 'g16.jpg',
            'grave_number' => 16,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(5)->toDateString(),
            'end_date' => now()->addYears(5)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 5,
            'latitude' => 52458300,
            'longitude' => 6058670,
            'image_hash_url' => 'g17.jpg',
            'grave_number' => 17,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(10)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 5,
            'latitude' => 52458400,
            'longitude' => 6058680,
            'image_hash_url' => 'g18.jpg',
            'grave_number' => 18,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(3)->toDateString(),
            'end_date' => now()->addYears(7)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 5,
            'latitude' => 52458500,
            'longitude' => 6058690,
            'image_hash_url' => 'g19.jpg',
            'grave_number' => 19,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(15)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 5,
            'latitude' => 52458600,
            'longitude' => 6058700,
            'image_hash_url' => 'g20.jpg',
            'grave_number' => 20,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(4)->toDateString(),
            'end_date' => now()->addYears(6)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 6,
            'latitude' => 52458700,
            'longitude' => 6058710,
            'image_hash_url' => 'g21.jpg',
            'grave_number' => 21,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(20)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 6,
            'latitude' => 52458800,
            'longitude' => 6058720,
            'image_hash_url' => 'g22.jpg',
            'grave_number' => 22,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(1)->toDateString(),
            'end_date' => now()->addYears(9)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 6,
            'latitude' => 52458900,
            'longitude' => 6058730,
            'image_hash_url' => 'g23.jpg',
            'grave_number' => 23,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(25)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 6,
            'latitude' => 52459000,
            'longitude' => 6058740,
            'image_hash_url' => 'g24.jpg',
            'grave_number' => 24,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(2)->toDateString(),
            'end_date' => now()->addYears(8)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 7,
            'latitude' => 52459100,
            'longitude' => 6058750,
            'image_hash_url' => 'g25.jpg',
            'grave_number' => 25,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(30)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 7,
            'latitude' => 52459200,
            'longitude' => 6058760,
            'image_hash_url' => 'g26.jpg',
            'grave_number' => 26,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(5)->toDateString(),
            'end_date' => now()->addYears(5)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 7,
            'latitude' => 52459300,
            'longitude' => 6058770,
            'image_hash_url' => 'g27.jpg',
            'grave_number' => 27,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(12)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 7,
            'latitude' => 52459400,
            'longitude' => 6058780,
            'image_hash_url' => 'g28.jpg',
            'grave_number' => 28,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(3)->toDateString(),
            'end_date' => now()->addYears(7)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 8,
            'latitude' => 52459500,
            'longitude' => 6058790,
            'image_hash_url' => 'g29.jpg',
            'grave_number' => 29,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(15)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 8,
            'latitude' => 52459600,
            'longitude' => 6058800,
            'image_hash_url' => 'g30.jpg',
            'grave_number' => 30,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(4)->toDateString(),
            'end_date' => now()->addYears(6)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 8,
            'latitude' => 52459700,
            'longitude' => 6058810,
            'image_hash_url' => 'g31.jpg',
            'grave_number' => 31,
            'status_id' => 1,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYears(20)->toDateString(),
        ]);

        Graves::create([
            'cemetery_id' => 8,
            'latitude' => 52459800,
            'longitude' => 6058820,
            'image_hash_url' => 'g32.jpg',
            'grave_number' => 32,
            'status_id' => 2,
            'description' => 'Dit is een grafomschrijving',
            'start_date' => now()->subYears(6)->toDateString(),
            'end_date' => now()->addYears(4)->toDateString(),
        ]);
    }
}