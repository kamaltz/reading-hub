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
        User::factory()->create([
            'name' => 'Admin ReadHub',
            'email' => 'admin@readhub.my.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Siswa0',
            'email' => 'siswa@readhub.my.id',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        
        $this->call([
            EducationalContentSeeder::class,
            EnglishTextbookSeeder::class,
        ]);
    }
}