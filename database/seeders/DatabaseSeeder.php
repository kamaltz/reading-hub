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
        // === ADMIN SEEDER ===
        // Hapus admin lama jika ada, lalu buat yang baru
        User::where('email', 'admin@readinghub.com')->orWhere('email', 'admin@readhub.my.id')->delete();
        User::create([
            'name' => 'Admin',
            'email' => 'admin@readhub.my.id', // Domain diperbarui
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // === STUDENT SEEDER (CONTOH) ===
        // Hapus siswa lama jika ada, lalu buat 10 siswa baru
        User::where('role', 'student')->delete();

        for ($i = 1; $i <= 10; $i++) {
            $year = date('y'); // Tahun saat ini, misal: 25
            $studentId = $year . str_pad($i, 4, '0', STR_PAD_LEFT); // Format: 250001, 250002, dst.

            User::create([
                'name' => 'Siswa ' . $i,
                'student_id' => $studentId,
                'email' => $studentId . '@readhub.my.id', // Domain diperbarui
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }
    }
}