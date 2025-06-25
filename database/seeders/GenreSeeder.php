<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Kosongkan tabel
        Genre::truncate();

        // Aktifkan kembali foreign key checks
        Schema::enableForeignKeyConstraints();

        $genres = [
            ['name' => 'Descriptive Text'],
            ['name' => 'Recount Text'],
            ['name' => 'Procedure Text'],
            ['name' => 'Expository Text'],
            ['name' => 'Narrative Text'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}