<?php

namespace Database\Seeders;

use App\Models\Chapter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel
        Chapter::truncate();

        // Aktifkan kembali foreign key checks
        Schema::enableForeignKeyConstraints();

        $chapters = [
            ['title' => 'Chapter 1: Great Athletes', 'sequence' => 1],
            ['title' => 'Chapter 2: Sports Events', 'sequence' => 2],
            ['title' => 'Chapter 3: Sports and Health', 'sequence' => 3],
            ['title' => 'Chapter 4: Healthy Foods', 'sequence' => 4],
            ['title' => 'Chapter 5: Graffiti', 'sequence' => 5],
            ['title' => 'Chapter 6: Fractured Stories', 'sequence' => 6],
        ];

        foreach ($chapters as $chapter) {
            Chapter::create($chapter);
        }
    }
}