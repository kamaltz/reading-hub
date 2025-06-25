<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@readinghub.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'admin',
        ]);

        // Membuat beberapa user siswa (opsional)
        User::factory(10)->create([
            'role' => 'student',
        ]);
    }
}