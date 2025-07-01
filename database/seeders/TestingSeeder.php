<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\ReadingMaterial;
use App\Models\HotsActivity;
use App\Models\StudentHotsActivityAnswer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class TestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nonaktifkan observer untuk efisiensi saat seeding massal
        StudentHotsActivityAnswer::flushEventListeners();

        $this->command->info('Memulai Seeder Pengujian Komprehensif...');
        $faker = Faker::create('id_ID'); // Menggunakan Faker untuk nama Indonesia

        // 1. Buat Genre dan Chapter
        $genreNarrative = Genre::firstOrCreate(['name' => 'Narrative Text']);
        $genreDescriptive = Genre::firstOrCreate(['name' => 'Descriptive Text']);
        $chapter1 = Chapter::firstOrCreate(['title' => 'Fables and Legends']);
        $chapter2 = Chapter::firstOrCreate(['title' => 'Famous Places']);
        $this->command->info('Genre dan Chapter telah disiapkan.');

        // 2. Buat Materi Bacaan Dummy
        $material1 = ReadingMaterial::create([
            'title' => 'The Fox and The Grapes',
            'content' => '<p>One hot summer’s day, a fox was strolling through an orchard. He saw a bunch of luscious grapes hanging from a high branch. “Just the thing to quench my thirst,” he said. Taking a few steps back, the fox jumped but failed to reach the grapes. He tried again and again, but still failed. At last, he gave up and said, “I’m sure they are sour anyway.”</p>',
            'chapter_id' => $chapter1->id,
            'genre_id' => $genreNarrative->id,
        ]);

        $material2 = ReadingMaterial::create([
            'title' => 'Borobudur Temple',
            'content' => '<h1>Borobudur Temple</h1><p>Borobudur is a 9th-century Mahayana Buddhist temple in Magelang Regency, Central Java, Indonesia. It is the world\'s largest Buddhist temple. The temple consists of nine stacked platforms, six square and three circular, topped by a central dome. It is decorated with 2,672 relief panels and 504 Buddha statues.</p>',
            'chapter_id' => $chapter2->id,
            'genre_id' => $genreDescriptive->id,
        ]);
        $this->command->info('2 Materi Bacaan telah dibuat.');

        // 3. Buat 5 Jenis Soal Berbeda (Total 5 aktivitas)
        // Soal 1: Pilihan Ganda
        HotsActivity::create([
            'reading_material_id' => $material1->id, 'type' => 'multiple_choice', 'position' => 1,
            'question' => 'What is the moral of the story "The Fox and The Grapes"?',
            'options' => ['A. Grapes are always sour', 'B. It is easy to despise what you cannot get', 'C. Foxes love grapes', 'D. Never give up'],
            'correct_answer' => 'B',
        ]);

        // Soal 2: Benar/Salah
        HotsActivity::create([
            'reading_material_id' => $material2->id, 'type' => 'true_false', 'position' => 1,
            'question' => 'Borobudur temple is located in West Java.',
            'correct_answer' => 'Salah',
        ]);

        // Soal 3: Isian Singkat
        HotsActivity::create([
            'reading_material_id' => $material2->id, 'type' => 'fill_in_blank', 'position' => 2,
            'question' => 'The temple is decorated with 2,672 relief panels and ______ Buddha statues.',
            'correct_answer' => '504',
        ]);

        // Soal 4: Berbasis Gambar (Pilihan Ganda)
        // Menggunakan placeholder untuk gambar
        HotsActivity::create([
            'reading_material_id' => $material1->id, 'type' => 'image_based', 'position' => 2,
            'question' => 'Based on the image, what animal is trying to get the fruit?',
            'image' => 'placeholders/fox_and_grapes.png', // Path placeholder
            'options' => ['A. Wolf', 'B. Dog', 'C. Fox', 'D. Cat'],
            'correct_answer' => 'C',
        ]);

        // Soal 5: Esai
        HotsActivity::create([
            'reading_material_id' => $material2->id, 'type' => 'essay', 'position' => 3,
            'question' => 'In your own words, describe what Borobudur is.',
            'correct_answer' => 'A large 9th-century Buddhist temple in Central Java, Indonesia.',
        ]);
        $this->command->info('5 Aktivitas dengan berbagai bentuk telah dibuat.');
        $allActivities = HotsActivity::all();

        // 4. Buat 10 Siswa dengan Nama Acak dan ID Berurutan
        $students = collect();
        $startId = 250001; // ID awal, misal untuk tahun 2025
        for ($i = 0; $i < 10; $i++) {
            $studentId = $startId + $i;
            $students->push(User::create([
                'name' => $faker->name,
                'student_id' => $studentId,
                'email' => $studentId . '@readhub.my.id',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]));
        }
        $this->command->info('10 Siswa Uji telah dibuat.');

        // 5. Simulasikan Siswa Menjawab Soal dengan Progress Berbeda
        $totalActivities = $allActivities->count();
        $students->each(function ($student, $index) use ($allActivities, $totalActivities) {
            // Siswa ke-0 menjawab 1 soal, siswa ke-1 menjawab 2, dst.
            // Kita batasi maksimal sejumlah soal yang ada.
            $questionsToAnswerCount = min($index + 1, $totalActivities);
            $activitiesToAnswer = $allActivities->random($questionsToAnswerCount);

            foreach ($activitiesToAnswer as $activity) {
                // Simulasikan jawaban benar atau salah secara acak
                $isCorrect = (bool)random_int(0, 1);
                $answerText = $isCorrect ? $activity->correct_answer : 'Jawaban Acak Salah';
                if ($activity->type === 'multiple_choice' || $activity->type === 'image_based') {
                    $answerText = $isCorrect ? substr($activity->correct_answer, 0, 1) : 'X';
                }

                StudentHotsActivityAnswer::create([
                    'user_id' => $student->id,
                    'hots_activity_id' => $activity->id,
                    'answer' => $answerText,
                    'is_correct' => $isCorrect
                ]);
            }
        });
        $this->command->info('Simulasi jawaban siswa selesai.');

        // 6. Hitung Ulang Progress Semua Siswa
        $this->command->info('Menghitung ulang progress semua siswa...');
        if ($totalActivities > 0) {
            $allStudents = User::where('role', 'student')->get();
            foreach ($allStudents as $student) {
                $answeredCount = $student->answers()->count();
                $progress = round(($answeredCount / $totalActivities) * 100);
                $student->update(['progress' => $progress]);
            }
        }
        $this->command->info('Progress siswa telah diperbarui.');
        $this->command->info('Seeder Pengujian Komprehensif selesai!');
    }
}