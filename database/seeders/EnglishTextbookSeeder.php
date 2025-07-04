<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\ReadingMaterial;
use App\Models\HotsActivity;

class EnglishTextbookSeeder extends Seeder
{
    public function run()
    {
        // Buat Genres jika belum ada
        $genres = [
            'Narrative Text',
            'Descriptive Text', 
            'Procedure Text',
            'Recount Text',
            'Report Text',
            'Announcement Text'
        ];

        foreach ($genres as $genreName) {
            Genre::firstOrCreate(['name' => $genreName]);
        }

        // Buat Chapters untuk Bab 1-6
        $chapters = [
            ['title' => 'Chapter 1: Great Athletes', 'sequence' => 1],
            ['title' => 'Chapter 2: Sports Events', 'sequence' => 2], 
            ['title' => 'Chapter 3: What Are You Going to Do Today?', 'sequence' => 3],
            ['title' => 'Chapter 4: Which One Is Your Best Getaway?', 'sequence' => 4],
            ['title' => 'Chapter 5: Let\'s Visit Niagara Falls', 'sequence' => 5],
            ['title' => 'Chapter 6: Giving Announcement', 'sequence' => 6],
        ];

        foreach ($chapters as $chapterData) {
            Chapter::firstOrCreate(['title' => $chapterData['title']], $chapterData);
        }

        // Ambil referensi genres dan chapters
        $narrativeGenre = Genre::where('name', 'Narrative Text')->first();
        $descriptiveGenre = Genre::where('name', 'Descriptive Text')->first();
        $procedureGenre = Genre::where('name', 'Procedure Text')->first();
        $recountGenre = Genre::where('name', 'Recount Text')->first();
        $reportGenre = Genre::where('name', 'Report Text')->first();
        $announcementGenre = Genre::where('name', 'Announcement Text')->first();

        $chapter1 = Chapter::where('title', 'Chapter 1: Great Athletes')->first();
        $chapter2 = Chapter::where('title', 'Chapter 2: Sports Events')->first();
        $chapter3 = Chapter::where('title', 'Chapter 3: What Are You Going to Do Today?')->first();
        $chapter4 = Chapter::where('title', 'Chapter 4: Which One Is Your Best Getaway?')->first();
        $chapter5 = Chapter::where('title', 'Chapter 5: Let\'s Visit Niagara Falls')->first();
        $chapter6 = Chapter::where('title', 'Chapter 6: Giving Announcement')->first();

        // CHAPTER 1: Great Athletes - Descriptive Text
        $material1 = ReadingMaterial::create([
            'title' => 'Cristiano Ronaldo: The Football Legend',
            'content' => '<h3>Cristiano Ronaldo: The Football Legend</h3>
            <p>Cristiano Ronaldo dos Santos Aveiro is one of the greatest football players of all time. Born on February 5, 1985, in Madeira, Portugal, he has become a global icon in the world of sports.</p>
            <p>Ronaldo is known for his incredible speed, powerful shots, and exceptional heading ability. He stands 1.87 meters tall and weighs around 84 kilograms. His athletic build and dedication to fitness have made him one of the most physically impressive athletes in football.</p>
            <p>Throughout his career, Ronaldo has played for several top clubs including Sporting CP, Manchester United, Real Madrid, Juventus, and Al Nassr. He has won numerous awards including five Ballon d\'Or trophies and has scored over 800 career goals.</p>
            <p>Off the field, Ronaldo is known for his charitable work and business ventures. He has donated millions to various causes and has built a successful brand around his name. His dedication, hard work, and never-give-up attitude make him an inspiration to millions of young athletes worldwide.</p>',
            'chapter_id' => $chapter1->id,
            'genre_id' => $descriptiveGenre->id,
        ]);

        // CHAPTER 2: Sports Events - Recount Text  
        $material2 = ReadingMaterial::create([
            'title' => 'My Experience at the School Sports Day',
            'content' => '<h3>My Experience at the School Sports Day</h3>
            <p>Last Friday, our school held its annual Sports Day. I was very excited because I had been training for the 100-meter sprint for weeks.</p>
            <p>The event started at 8 AM with an opening ceremony. All students gathered at the school field wearing their house colors. The principal gave a motivating speech about sportsmanship and fair play.</p>
            <p>My race was scheduled for 10 AM. I felt nervous as I walked to the starting line. There were eight participants, and the competition looked tough. When the whistle blew, I ran as fast as I could.</p>
            <p>Unfortunately, I came in fourth place, but I wasn\'t disappointed. I had improved my personal best time by two seconds! My friends cheered for me, and my teacher congratulated me on my effort.</p>
            <p>The Sports Day ended with a closing ceremony at 3 PM. Although I didn\'t win a medal, I learned that participating and doing your best is more important than winning. It was truly a memorable day.</p>',
            'chapter_id' => $chapter2->id,
            'genre_id' => $recountGenre->id,
        ]);

        // CHAPTER 3: Daily Activities - Procedure Text
        $material3 = ReadingMaterial::create([
            'title' => 'How to Start Your Day Productively',
            'content' => '<h3>How to Start Your Day Productively</h3>
            <p>Starting your day right can make a huge difference in your productivity and mood. Here\'s a simple guide to help you have a productive morning routine.</p>
            <p><strong>Materials needed:</strong></p>
            <ul>
                <li>Alarm clock</li>
                <li>Water bottle</li>
                <li>Notebook and pen</li>
                <li>Healthy breakfast ingredients</li>
            </ul>
            <p><strong>Steps:</strong></p>
            <ol>
                <li>Wake up early, preferably at the same time every day</li>
                <li>Drink a glass of water immediately after waking up</li>
                <li>Do 10-15 minutes of light exercise or stretching</li>
                <li>Take a refreshing shower</li>
                <li>Eat a nutritious breakfast</li>
                <li>Write down three main goals for the day</li>
                <li>Review your schedule and prioritize tasks</li>
                <li>Start with the most important task first</li>
            </ol>
            <p>Following this routine consistently will help you feel more energized and focused throughout the day.</p>',
            'chapter_id' => $chapter3->id,
            'genre_id' => $procedureGenre->id,
        ]);

        // CHAPTER 4: Holiday Destinations - Descriptive Text
        $material4 = ReadingMaterial::create([
            'title' => 'Bali: The Island of Gods',
            'content' => '<h3>Bali: The Island of Gods</h3>
            <p>Bali is one of Indonesia\'s most popular tourist destinations, known for its stunning beaches, rich culture, and spiritual atmosphere. Located between Java and Lombok, this island province offers something for every type of traveler.</p>
            <p>The island is famous for its beautiful temples, including Tanah Lot, Uluwatu, and Besakih. These ancient Hindu temples showcase intricate architecture and offer breathtaking views of the surrounding landscapes.</p>
            <p>Bali\'s beaches are world-renowned, from the surfing paradise of Uluwatu to the calm waters of Sanur. The island also boasts lush rice terraces in Jatiluwih and Tegallalang, which create stunning green landscapes that attract photographers from around the world.</p>
            <p>The Balinese culture is deeply rooted in Hindu traditions, visible in daily ceremonies, colorful festivals, and traditional arts like dance and wood carving. The local cuisine, featuring dishes like nasi goreng, satay, and fresh tropical fruits, adds to the island\'s appeal.</p>
            <p>Whether you\'re seeking adventure, relaxation, or cultural experiences, Bali truly lives up to its reputation as the "Island of Gods."</p>',
            'chapter_id' => $chapter4->id,
            'genre_id' => $descriptiveGenre->id,
        ]);

        // CHAPTER 5: Niagara Falls - Report Text
        $material5 = ReadingMaterial::create([
            'title' => 'Niagara Falls: A Natural Wonder',
            'content' => '<h3>Niagara Falls: A Natural Wonder</h3>
            <p>Niagara Falls is a group of three waterfalls located on the border between the United States and Canada. It consists of the American Falls, Bridal Veil Falls, and the largest, Horseshoe Falls (also known as Canadian Falls).</p>
            <p><strong>Physical Characteristics:</strong></p>
            <p>The falls have a total height of 167 feet (51 meters) and a width of 2,700 feet (823 meters). Approximately 6 million cubic feet of water flow over the falls every minute during peak flow. The water comes from the Great Lakes and flows into the Niagara River.</p>
            <p><strong>Formation:</strong></p>
            <p>Niagara Falls was formed during the last ice age, approximately 12,000 years ago. As glaciers retreated, they carved out the Great Lakes and the Niagara River, creating the dramatic drop that forms the falls today.</p>
            <p><strong>Tourism and Economy:</strong></p>
            <p>The falls attract over 30 million visitors annually, making it one of the most visited tourist attractions in North America. The tourism industry provides thousands of jobs and generates billions of dollars in revenue for both countries.</p>
            <p><strong>Hydroelectric Power:</strong></p>
            <p>Niagara Falls is also an important source of hydroelectric power, generating electricity for both the United States and Canada. The power plants can produce up to 4.4 million kilowatts of electricity.</p>',
            'chapter_id' => $chapter5->id,
            'genre_id' => $reportGenre->id,
        ]);

        // CHAPTER 6: Announcements - Announcement Text
        $material6 = ReadingMaterial::create([
            'title' => 'School Announcement: Science Fair Competition',
            'content' => '<h3>ANNOUNCEMENT</h3>
            <div style="text-align: center; margin: 20px 0;">
                <h4>ANNUAL SCIENCE FAIR COMPETITION 2024</h4>
            </div>
            <p><strong>To:</strong> All Grade 10 Students<br>
            <strong>From:</strong> Science Department<br>
            <strong>Date:</strong> March 15, 2024</p>
            
            <p>We are pleased to announce that our school will be holding the Annual Science Fair Competition on <strong>April 20-21, 2024</strong> in the school gymnasium.</p>
            
            <p><strong>Competition Categories:</strong></p>
            <ul>
                <li>Physics and Engineering</li>
                <li>Chemistry and Materials Science</li>
                <li>Biology and Environmental Science</li>
                <li>Mathematics and Computer Science</li>
            </ul>
            
            <p><strong>Important Information:</strong></p>
            <ul>
                <li>Registration deadline: April 5, 2024</li>
                <li>Maximum 3 students per team</li>
                <li>Registration fee: $10 per team</li>
                <li>Prizes will be awarded for 1st, 2nd, and 3rd place in each category</li>
            </ul>
            
            <p><strong>Registration:</strong><br>
            Please submit your registration form to the Science Department office or contact Mrs. Johnson at extension 234.</p>
            
            <p>This is a great opportunity to showcase your scientific knowledge and creativity. We encourage all students to participate!</p>
            
            <p><strong>Science Department</strong><br>
            Green Valley High School</p>',
            'chapter_id' => $chapter6->id,
            'genre_id' => $announcementGenre->id,
        ]);

        // Buat soal-soal untuk setiap materi
        $this->createActivities($material1, $material2, $material3, $material4, $material5, $material6);

        $this->command->info('English Textbook content (Chapters 1-6) seeded successfully!');
    }

    private function createActivities($material1, $material2, $material3, $material4, $material5, $material6)
    {
        // SOAL CHAPTER 1: Cristiano Ronaldo
        $activities1 = [
            [
                'reading_material_id' => $material1->id,
                'type' => 'multiple_choice',
                'question' => 'When was Cristiano Ronaldo born?',
                'options' => ['February 5, 1985', 'February 5, 1984', 'March 5, 1985', 'February 15, 1985'],
                'correct_answer' => 'February 5, 1985',
                'sequence' => 1,
            ],
            [
                'reading_material_id' => $material1->id,
                'type' => 'multiple_choice',
                'question' => 'How many Ballon d\'Or trophies has Ronaldo won?',
                'options' => ['Three', 'Four', 'Five', 'Six'],
                'correct_answer' => 'Five',
                'sequence' => 2,
            ],
            [
                'reading_material_id' => $material1->id,
                'type' => 'true_false',
                'question' => 'Ronaldo has scored over 800 career goals.',
                'correct_answer' => 'True',
                'sequence' => 3,
            ],
            [
                'reading_material_id' => $material1->id,
                'type' => 'essay',
                'question' => 'What makes Cristiano Ronaldo an inspiration to young athletes? Explain your answer.',
                'correct_answer' => 'Ronaldo inspires young athletes through his dedication, hard work, never-give-up attitude, charitable work, and his journey from a small island to becoming a global icon.',
                'sequence' => 4,
            ],
            [
                'reading_material_id' => $material1->id,
                'type' => 'fill_in_blank',
                'question' => 'Ronaldo stands _____ meters tall and weighs around _____ kilograms.',
                'correct_answer' => '1.87, 84',
                'sequence' => 5,
            ],
        ];

        // SOAL CHAPTER 2: Sports Day
        $activities2 = [
            [
                'reading_material_id' => $material2->id,
                'type' => 'multiple_choice',
                'question' => 'When did the school Sports Day take place?',
                'options' => ['Last Thursday', 'Last Friday', 'Last Saturday', 'Last Sunday'],
                'correct_answer' => 'Last Friday',
                'sequence' => 1,
            ],
            [
                'reading_material_id' => $material2->id,
                'type' => 'multiple_choice',
                'question' => 'What place did the writer finish in the race?',
                'options' => ['Second', 'Third', 'Fourth', 'Fifth'],
                'correct_answer' => 'Fourth',
                'sequence' => 2,
            ],
            [
                'reading_material_id' => $material2->id,
                'type' => 'true_false',
                'question' => 'The writer was disappointed with their performance.',
                'correct_answer' => 'False',
                'sequence' => 3,
            ],
            [
                'reading_material_id' => $material2->id,
                'type' => 'essay',
                'question' => 'What lesson did the writer learn from the Sports Day experience?',
                'correct_answer' => 'The writer learned that participating and doing your best is more important than winning.',
                'sequence' => 4,
            ],
        ];

        // SOAL CHAPTER 3: Daily Activities
        $activities3 = [
            [
                'reading_material_id' => $material3->id,
                'type' => 'multiple_choice',
                'question' => 'What should you do immediately after waking up?',
                'options' => ['Exercise', 'Drink water', 'Take a shower', 'Eat breakfast'],
                'correct_answer' => 'Drink water',
                'sequence' => 1,
            ],
            [
                'reading_material_id' => $material3->id,
                'type' => 'true_false',
                'question' => 'You should write down three main goals for the day.',
                'correct_answer' => 'True',
                'sequence' => 2,
            ],
            [
                'reading_material_id' => $material3->id,
                'type' => 'essay',
                'question' => 'Why is it important to have a morning routine? Explain your answer.',
                'correct_answer' => 'A morning routine helps you feel more energized and focused throughout the day, improves productivity and mood.',
                'sequence' => 3,
            ],
        ];

        // SOAL CHAPTER 4: Bali
        $activities4 = [
            [
                'reading_material_id' => $material4->id,
                'type' => 'multiple_choice',
                'question' => 'Where is Bali located?',
                'options' => ['Between Java and Sumatra', 'Between Java and Lombok', 'Between Sumatra and Lombok', 'Between Java and Sulawesi'],
                'correct_answer' => 'Between Java and Lombok',
                'sequence' => 1,
            ],
            [
                'reading_material_id' => $material4->id,
                'type' => 'multiple_choice',
                'question' => 'Which of the following is NOT mentioned as a famous temple in Bali?',
                'options' => ['Tanah Lot', 'Uluwatu', 'Besakih', 'Prambanan'],
                'correct_answer' => 'Prambanan',
                'sequence' => 2,
            ],
            [
                'reading_material_id' => $material4->id,
                'type' => 'true_false',
                'question' => 'Bali is known as the "Island of Gods."',
                'correct_answer' => 'True',
                'sequence' => 3,
            ],
            [
                'reading_material_id' => $material4->id,
                'type' => 'essay',
                'question' => 'What makes Bali attractive to different types of travelers?',
                'correct_answer' => 'Bali offers stunning beaches, rich culture, spiritual atmosphere, beautiful temples, lush rice terraces, traditional arts, and delicious local cuisine.',
                'sequence' => 4,
            ],
        ];

        // SOAL CHAPTER 5: Niagara Falls
        $activities5 = [
            [
                'reading_material_id' => $material5->id,
                'type' => 'multiple_choice',
                'question' => 'How many waterfalls make up Niagara Falls?',
                'options' => ['Two', 'Three', 'Four', 'Five'],
                'correct_answer' => 'Three',
                'sequence' => 1,
            ],
            [
                'reading_material_id' => $material5->id,
                'type' => 'multiple_choice',
                'question' => 'What is the total height of Niagara Falls?',
                'options' => ['157 feet', '167 feet', '177 feet', '187 feet'],
                'correct_answer' => '167 feet',
                'sequence' => 2,
            ],
            [
                'reading_material_id' => $material5->id,
                'type' => 'true_false',
                'question' => 'Niagara Falls attracts over 30 million visitors annually.',
                'correct_answer' => 'True',
                'sequence' => 3,
            ],
            [
                'reading_material_id' => $material5->id,
                'type' => 'essay',
                'question' => 'Explain two important functions of Niagara Falls besides tourism.',
                'correct_answer' => 'Niagara Falls serves as an important source of hydroelectric power, generating electricity for both the United States and Canada, and it plays a role in the ecosystem as part of the Great Lakes water system.',
                'sequence' => 4,
            ],
        ];

        // SOAL CHAPTER 6: Announcement
        $activities6 = [
            [
                'reading_material_id' => $material6->id,
                'type' => 'multiple_choice',
                'question' => 'When will the Science Fair Competition be held?',
                'options' => ['April 15-16, 2024', 'April 20-21, 2024', 'April 25-26, 2024', 'May 20-21, 2024'],
                'correct_answer' => 'April 20-21, 2024',
                'sequence' => 1,
            ],
            [
                'reading_material_id' => $material6->id,
                'type' => 'multiple_choice',
                'question' => 'What is the registration deadline?',
                'options' => ['March 5, 2024', 'April 1, 2024', 'April 5, 2024', 'April 10, 2024'],
                'correct_answer' => 'April 5, 2024',
                'sequence' => 2,
            ],
            [
                'reading_material_id' => $material6->id,
                'type' => 'true_false',
                'question' => 'The maximum number of students per team is 3.',
                'correct_answer' => 'True',
                'sequence' => 3,
            ],
            [
                'reading_material_id' => $material6->id,
                'type' => 'fill_in_blank',
                'question' => 'The registration fee is _____ per team.',
                'correct_answer' => '$10',
                'sequence' => 4,
            ],
            [
                'reading_material_id' => $material6->id,
                'type' => 'essay',
                'question' => 'List the four competition categories mentioned in the announcement.',
                'correct_answer' => '1. Physics and Engineering, 2. Chemistry and Materials Science, 3. Biology and Environmental Science, 4. Mathematics and Computer Science',
                'sequence' => 5,
            ],
        ];

        // Gabungkan semua activities
        $allActivities = array_merge($activities1, $activities2, $activities3, $activities4, $activities5, $activities6);

        // Insert activities
        foreach ($allActivities as $activityData) {
            HotsActivity::create($activityData);
        }
    }
}