<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'role_id' => 1,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Beheerder',
            'last_name' => 'User',
            'email' => 'beheerder@example.com',
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

        User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'role_id' => 4,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Jan',
            'last_name' => 'Jansen',
            'email' => 'jan.jansen@example.com',
            'role_id' => 1,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Piet',
            'last_name' => 'Pietersen',
            'email' => 'piet.pietersen@example.com',
            'role_id' => 1,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Klaas',
            'last_name' => 'Klaassen',
            'email' => 'klaas.klaassen@example.com',
            'role_id' => 1,
            'password_hash' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Marie',
            'last_name' => 'Curie',
            'email' => 'mariecurie@example.com',
            'role_id' => 1,
            'password_hash' => Hash::make('password'),
        ]);
    }
}