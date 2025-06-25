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
        // Membuat pengguna default
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@readinghub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::factory(10)->create(['role' => 'student']);
        
        // Memanggil seeder untuk Genre dan Chapter
        $this->call([
            GenreSeeder::class,
            ChapterSeeder::class,
        ]);
    }
}