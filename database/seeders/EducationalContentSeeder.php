<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\ReadingMaterial;
use App\Models\HotsActivity;

class EducationalContentSeeder extends Seeder
{
    public function run()
    {
        // Create Genres
        $genres = [
            ['name' => 'Narrative Text'],
            ['name' => 'Descriptive Text'],
            ['name' => 'Procedure Text'],
            ['name' => 'Recount Text'],
            ['name' => 'Report Text'],
        ];

        foreach ($genres as $genreData) {
            Genre::create($genreData);
        }

        // Create Chapters
        $chapters = [
            ['title' => 'Introduction to English Texts', 'sequence' => 1],
            ['title' => 'Narrative Texts', 'sequence' => 2],
            ['title' => 'Descriptive Texts', 'sequence' => 3],
            ['title' => 'Procedure Texts', 'sequence' => 4],
            ['title' => 'Recount Texts', 'sequence' => 5],
            ['title' => 'Report Texts', 'sequence' => 6],
        ];

        foreach ($chapters as $chapterData) {
            Chapter::create($chapterData);
        }

        // Get created records
        $narrativeGenre = Genre::where('name', 'Narrative Text')->first();
        $descriptiveGenre = Genre::where('name', 'Descriptive Text')->first();
        $procedureGenre = Genre::where('name', 'Procedure Text')->first();
        
        $narrativeChapter = Chapter::where('title', 'Narrative Texts')->first();
        $descriptiveChapter = Chapter::where('title', 'Descriptive Texts')->first();
        $procedureChapter = Chapter::where('title', 'Procedure Texts')->first();

        // Create Reading Materials
        $materials = [
            [
                'title' => 'The Legend of Lake Toba',
                'content' => '<h3>The Legend of Lake Toba</h3><p>Long ago, there lived a poor fisherman in North Sumatra. One day, he caught a beautiful golden fish. The fish begged for its life and promised to grant him a wish. The fisherman, feeling sorry, released the fish back into the water.</p><p>The next day, the fisherman found a beautiful woman waiting at his home. She said she was the golden fish he had saved, transformed into human form. They fell in love and got married, but she made him promise never to tell anyone about her true identity.</p><p>Years passed, and they had a son named Samosir. The boy was lazy and always ate too much. One day, when Samosir forgot to bring his father lunch, the angry fisherman shouted, "You are just like your mother, a fish!" Breaking his promise, the earth began to shake, and water gushed from the ground, creating the beautiful Lake Toba we know today.</p>',
                'chapter_id' => $narrativeChapter->id,
                'genre_id' => $narrativeGenre->id,
            ],
            [
                'title' => 'Borobudur Temple',
                'content' => '<h3>Borobudur Temple</h3><p>Borobudur is a magnificent Buddhist temple located in Central Java, Indonesia. Built in the 8th and 9th centuries during the Sailendra Dynasty, it is one of the greatest Buddhist monuments in the world.</p><p>The temple consists of nine stacked platforms, six square and three circular, topped by a central dome. It is decorated with 2,672 relief panels and 504 Buddha statues. The central dome is surrounded by 72 Buddha statues, each seated inside a perforated stupa.</p><p>Borobudur is built as a single large stupa and represents the Buddhist cosmology. Pilgrims walk clockwise around each level, following the path of enlightenment. The temple was abandoned in the 14th century and rediscovered in 1814. Today, it is a UNESCO World Heritage Site and attracts millions of visitors annually.</p>',
                'chapter_id' => $descriptiveChapter->id,
                'genre_id' => $descriptiveGenre->id,
            ],
            [
                'title' => 'How to Make Fried Rice',
                'content' => '<h3>How to Make Indonesian Fried Rice</h3><p><strong>Ingredients:</strong></p><ul><li>2 cups cooked rice (preferably day-old)</li><li>2 eggs</li><li>3 cloves garlic, minced</li><li>2 tablespoons soy sauce</li><li>1 tablespoon oil</li><li>Salt and pepper to taste</li><li>Green onions for garnish</li></ul><p><strong>Instructions:</strong></p><ol><li>Heat oil in a large pan or wok over medium-high heat.</li><li>Add minced garlic and stir-fry until fragrant.</li><li>Push garlic to one side and scramble the eggs on the other side.</li><li>Add the cooked rice and mix everything together.</li><li>Add soy sauce, salt, and pepper. Stir well.</li><li>Cook for 3-5 minutes until heated through.</li><li>Garnish with chopped green onions and serve hot.</li></ol>',
                'chapter_id' => $procedureChapter->id,
                'genre_id' => $procedureGenre->id,
            ],
        ];

        foreach ($materials as $materialData) {
            ReadingMaterial::create($materialData);
        }

        // Create Activities/Questions
        $lakeToba = ReadingMaterial::where('title', 'The Legend of Lake Toba')->first();
        $borobudur = ReadingMaterial::where('title', 'Borobudur Temple')->first();
        $friedRice = ReadingMaterial::where('title', 'How to Make Fried Rice')->first();

        $activities = [
            // Lake Toba Questions
            [
                'reading_material_id' => $lakeToba->id,
                'type' => 'multiple_choice',
                'question' => 'What did the fisherman catch that changed his life?',
                'options' => json_encode(['A golden fish', 'A silver coin', 'A magic stone', 'A beautiful pearl']),
                'correct_answer' => 'A golden fish',
            ],
            [
                'reading_material_id' => $lakeToba->id,
                'type' => 'essay',
                'question' => 'What lesson can we learn from the story of Lake Toba?',
                'correct_answer' => 'We should keep our promises and control our anger. Breaking promises can have serious consequences.',
            ],
            [
                'reading_material_id' => $lakeToba->id,
                'type' => 'true_false',
                'question' => 'The fisherman kept his promise to his wife throughout the story.',
                'correct_answer' => 'False',
            ],

            // Borobudur Questions
            [
                'reading_material_id' => $borobudur->id,
                'type' => 'multiple_choice',
                'question' => 'When was Borobudur Temple built?',
                'options' => json_encode(['6th-7th centuries', '8th-9th centuries', '10th-11th centuries', '12th-13th centuries']),
                'correct_answer' => '8th-9th centuries',
            ],
            [
                'reading_material_id' => $borobudur->id,
                'type' => 'fill_in_blank',
                'question' => 'Borobudur has _____ relief panels decorating the temple.',
                'correct_answer' => '2,672',
            ],
            [
                'reading_material_id' => $borobudur->id,
                'type' => 'true_false',
                'question' => 'Borobudur is a UNESCO World Heritage Site.',
                'correct_answer' => 'True',
            ],

            // Fried Rice Questions
            [
                'reading_material_id' => $friedRice->id,
                'type' => 'multiple_choice',
                'question' => 'What type of rice is recommended for making fried rice?',
                'options' => json_encode(['Fresh cooked rice', 'Day-old rice', 'Uncooked rice', 'Frozen rice']),
                'correct_answer' => 'Day-old rice',
            ],
            [
                'reading_material_id' => $friedRice->id,
                'type' => 'essay',
                'question' => 'Why is it important to use day-old rice when making fried rice?',
                'correct_answer' => 'Day-old rice is drier and less sticky, which prevents the fried rice from becoming mushy and helps achieve better texture.',
            ],
            [
                'reading_material_id' => $friedRice->id,
                'type' => 'fill_in_blank',
                'question' => 'The first step is to heat _____ in a large pan or wok.',
                'correct_answer' => 'oil',
            ],

            // Paragraph with blanks questions
            [
                'reading_material_id' => $lakeToba->id,
                'type' => 'paragraph_blanks',
                'question' => 'Complete the paragraph about Lake Toba:

Long ago, there lived a poor _____ in North Sumatra. One day, he caught a beautiful _____ fish. The fish begged for its life and promised to grant him a _____. The fisherman, feeling sorry, _____ the fish back into the water. Years later, they had a son named _____ who was lazy and always ate too much.',
                'correct_answer' => 'fisherman, golden, wish, released, Samosir',
            ],
            [
                'reading_material_id' => $borobudur->id,
                'type' => 'paragraph_blanks',
                'question' => 'Fill in the blanks about Borobudur Temple:

Borobudur is a magnificent _____ temple located in Central Java, Indonesia. Built in the _____ and 9th centuries, it consists of nine stacked _____, six square and three circular. The temple is decorated with _____ relief panels and 504 Buddha statues. Today, it is a UNESCO _____ Heritage Site.',
                'correct_answer' => 'Buddhist, 8th, platforms, 2672, World',
            ],
            [
                'reading_material_id' => $friedRice->id,
                'type' => 'paragraph_blanks',
                'question' => 'Complete the cooking instructions:

Heat _____ in a large pan over medium-high heat. Add minced _____ and stir-fry until fragrant. Push garlic to one side and _____ the eggs on the other side. Add the cooked _____ and mix everything together. Add soy sauce, _____, and pepper.',
                'correct_answer' => 'oil, garlic, scramble, rice, salt',
            ],
        ];

        foreach ($activities as $activityData) {
            HotsActivity::create($activityData);
        }

        $this->command->info('Educational content seeded successfully!');
        $this->command->info('Created: ' . count($genres) . ' genres, ' . count($chapters) . ' chapters, ' . count($materials) . ' materials, ' . (count($activities) + 3) . ' activities');
    }
}