-- SQL untuk Upload Materi Bahasa Inggris Bab 1-6
-- Pastikan database sudah ter-migrate sebelum menjalankan script ini

-- Insert Genres (jika belum ada)
INSERT IGNORE INTO genres (name, created_at, updated_at) VALUES
('Narrative Text', NOW(), NOW()),
('Descriptive Text', NOW(), NOW()),
('Procedure Text', NOW(), NOW()),
('Recount Text', NOW(), NOW()),
('Report Text', NOW(), NOW()),
('Announcement Text', NOW(), NOW());

-- Insert Chapters untuk Bab 1-6
INSERT IGNORE INTO chapters (title, sequence, created_at, updated_at) VALUES
('Chapter 1: Great Athletes', 1, NOW(), NOW()),
('Chapter 2: Sports Events', 2, NOW(), NOW()),
('Chapter 3: What Are You Going to Do Today?', 3, NOW(), NOW()),
('Chapter 4: Which One Is Your Best Getaway?', 4, NOW(), NOW()),
('Chapter 5: Let\'s Visit Niagara Falls', 5, NOW(), NOW()),
('Chapter 6: Giving Announcement', 6, NOW(), NOW());

-- Insert Reading Materials
INSERT INTO reading_materials (title, content, chapter_id, genre_id, created_at, updated_at) VALUES

-- CHAPTER 1: Great Athletes (Descriptive Text)
('Cristiano Ronaldo: The Football Legend', 
'<h3>Cristiano Ronaldo: The Football Legend</h3>
<p>Cristiano Ronaldo dos Santos Aveiro is one of the greatest football players of all time. Born on February 5, 1985, in Madeira, Portugal, he has become a global icon in the world of sports.</p>
<p>Ronaldo is known for his incredible speed, powerful shots, and exceptional heading ability. He stands 1.87 meters tall and weighs around 84 kilograms. His athletic build and dedication to fitness have made him one of the most physically impressive athletes in football.</p>
<p>Throughout his career, Ronaldo has played for several top clubs including Sporting CP, Manchester United, Real Madrid, Juventus, and Al Nassr. He has won numerous awards including five Ballon d\'Or trophies and has scored over 800 career goals.</p>
<p>Off the field, Ronaldo is known for his charitable work and business ventures. He has donated millions to various causes and has built a successful brand around his name. His dedication, hard work, and never-give-up attitude make him an inspiration to millions of young athletes worldwide.</p>',
(SELECT id FROM chapters WHERE title = 'Chapter 1: Great Athletes'),
(SELECT id FROM genres WHERE name = 'Descriptive Text'),
NOW(), NOW()),

-- CHAPTER 2: Sports Events (Recount Text)
('My Experience at the School Sports Day',
'<h3>My Experience at the School Sports Day</h3>
<p>Last Friday, our school held its annual Sports Day. I was very excited because I had been training for the 100-meter sprint for weeks.</p>
<p>The event started at 8 AM with an opening ceremony. All students gathered at the school field wearing their house colors. The principal gave a motivating speech about sportsmanship and fair play.</p>
<p>My race was scheduled for 10 AM. I felt nervous as I walked to the starting line. There were eight participants, and the competition looked tough. When the whistle blew, I ran as fast as I could.</p>
<p>Unfortunately, I came in fourth place, but I wasn\'t disappointed. I had improved my personal best time by two seconds! My friends cheered for me, and my teacher congratulated me on my effort.</p>
<p>The Sports Day ended with a closing ceremony at 3 PM. Although I didn\'t win a medal, I learned that participating and doing your best is more important than winning. It was truly a memorable day.</p>',
(SELECT id FROM chapters WHERE title = 'Chapter 2: Sports Events'),
(SELECT id FROM genres WHERE name = 'Recount Text'),
NOW(), NOW()),

-- CHAPTER 3: Daily Activities (Procedure Text)
('How to Start Your Day Productively',
'<h3>How to Start Your Day Productively</h3>
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
(SELECT id FROM chapters WHERE title = 'Chapter 3: What Are You Going to Do Today?'),
(SELECT id FROM genres WHERE name = 'Procedure Text'),
NOW(), NOW()),

-- CHAPTER 4: Holiday Destinations (Descriptive Text)
('Bali: The Island of Gods',
'<h3>Bali: The Island of Gods</h3>
<p>Bali is one of Indonesia\'s most popular tourist destinations, known for its stunning beaches, rich culture, and spiritual atmosphere. Located between Java and Lombok, this island province offers something for every type of traveler.</p>
<p>The island is famous for its beautiful temples, including Tanah Lot, Uluwatu, and Besakih. These ancient Hindu temples showcase intricate architecture and offer breathtaking views of the surrounding landscapes.</p>
<p>Bali\'s beaches are world-renowned, from the surfing paradise of Uluwatu to the calm waters of Sanur. The island also boasts lush rice terraces in Jatiluwih and Tegallalang, which create stunning green landscapes that attract photographers from around the world.</p>
<p>The Balinese culture is deeply rooted in Hindu traditions, visible in daily ceremonies, colorful festivals, and traditional arts like dance and wood carving. The local cuisine, featuring dishes like nasi goreng, satay, and fresh tropical fruits, adds to the island\'s appeal.</p>
<p>Whether you\'re seeking adventure, relaxation, or cultural experiences, Bali truly lives up to its reputation as the "Island of Gods."</p>',
(SELECT id FROM chapters WHERE title = 'Chapter 4: Which One Is Your Best Getaway?'),
(SELECT id FROM genres WHERE name = 'Descriptive Text'),
NOW(), NOW()),

-- CHAPTER 5: Niagara Falls (Report Text)
('Niagara Falls: A Natural Wonder',
'<h3>Niagara Falls: A Natural Wonder</h3>
<p>Niagara Falls is a group of three waterfalls located on the border between the United States and Canada. It consists of the American Falls, Bridal Veil Falls, and the largest, Horseshoe Falls (also known as Canadian Falls).</p>
<p><strong>Physical Characteristics:</strong></p>
<p>The falls have a total height of 167 feet (51 meters) and a width of 2,700 feet (823 meters). Approximately 6 million cubic feet of water flow over the falls every minute during peak flow. The water comes from the Great Lakes and flows into the Niagara River.</p>
<p><strong>Formation:</strong></p>
<p>Niagara Falls was formed during the last ice age, approximately 12,000 years ago. As glaciers retreated, they carved out the Great Lakes and the Niagara River, creating the dramatic drop that forms the falls today.</p>
<p><strong>Tourism and Economy:</strong></p>
<p>The falls attract over 30 million visitors annually, making it one of the most visited tourist attractions in North America. The tourism industry provides thousands of jobs and generates billions of dollars in revenue for both countries.</p>
<p><strong>Hydroelectric Power:</strong></p>
<p>Niagara Falls is also an important source of hydroelectric power, generating electricity for both the United States and Canada. The power plants can produce up to 4.4 million kilowatts of electricity.</p>',
(SELECT id FROM chapters WHERE title = 'Chapter 5: Let\'s Visit Niagara Falls'),
(SELECT id FROM genres WHERE name = 'Report Text'),
NOW(), NOW()),

-- CHAPTER 6: Announcements (Announcement Text)
('School Announcement: Science Fair Competition',
'<h3>ANNOUNCEMENT</h3>
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
(SELECT id FROM chapters WHERE title = 'Chapter 6: Giving Announcement'),
(SELECT id FROM genres WHERE name = 'Announcement Text'),
NOW(), NOW());

-- Insert HOTS Activities (Soal-soal)

-- SOAL CHAPTER 1: Cristiano Ronaldo
INSERT INTO hots_activities (reading_material_id, type, question, options, correct_answer, sequence, created_at, updated_at) VALUES

((SELECT id FROM reading_materials WHERE title = 'Cristiano Ronaldo: The Football Legend'), 
'multiple_choice', 
'When was Cristiano Ronaldo born?', 
'["February 5, 1985", "February 5, 1984", "March 5, 1985", "February 15, 1985"]', 
'February 5, 1985', 1, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Cristiano Ronaldo: The Football Legend'), 
'multiple_choice', 
'How many Ballon d\'Or trophies has Ronaldo won?', 
'["Three", "Four", "Five", "Six"]', 
'Five', 2, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Cristiano Ronaldo: The Football Legend'), 
'true_false', 
'Ronaldo has scored over 800 career goals.', 
NULL, 
'True', 3, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Cristiano Ronaldo: The Football Legend'), 
'essay', 
'What makes Cristiano Ronaldo an inspiration to young athletes? Explain your answer.', 
NULL, 
'Ronaldo inspires young athletes through his dedication, hard work, never-give-up attitude, charitable work, and his journey from a small island to becoming a global icon.', 4, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Cristiano Ronaldo: The Football Legend'), 
'fill_in_blank', 
'Ronaldo stands _____ meters tall and weighs around _____ kilograms.', 
NULL, 
'1.87, 84', 5, NOW(), NOW()),

-- SOAL CHAPTER 2: Sports Day
((SELECT id FROM reading_materials WHERE title = 'My Experience at the School Sports Day'), 
'multiple_choice', 
'When did the school Sports Day take place?', 
'["Last Thursday", "Last Friday", "Last Saturday", "Last Sunday"]', 
'Last Friday', 1, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'My Experience at the School Sports Day'), 
'multiple_choice', 
'What place did the writer finish in the race?', 
'["Second", "Third", "Fourth", "Fifth"]', 
'Fourth', 2, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'My Experience at the School Sports Day'), 
'true_false', 
'The writer was disappointed with their performance.', 
NULL, 
'False', 3, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'My Experience at the School Sports Day'), 
'essay', 
'What lesson did the writer learn from the Sports Day experience?', 
NULL, 
'The writer learned that participating and doing your best is more important than winning.', 4, NOW(), NOW()),

-- SOAL CHAPTER 3: Daily Activities
((SELECT id FROM reading_materials WHERE title = 'How to Start Your Day Productively'), 
'multiple_choice', 
'What should you do immediately after waking up?', 
'["Exercise", "Drink water", "Take a shower", "Eat breakfast"]', 
'Drink water', 1, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'How to Start Your Day Productively'), 
'true_false', 
'You should write down three main goals for the day.', 
NULL, 
'True', 2, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'How to Start Your Day Productively'), 
'essay', 
'Why is it important to have a morning routine? Explain your answer.', 
NULL, 
'A morning routine helps you feel more energized and focused throughout the day, improves productivity and mood.', 3, NOW(), NOW()),

-- SOAL CHAPTER 4: Bali
((SELECT id FROM reading_materials WHERE title = 'Bali: The Island of Gods'), 
'multiple_choice', 
'Where is Bali located?', 
'["Between Java and Sumatra", "Between Java and Lombok", "Between Sumatra and Lombok", "Between Java and Sulawesi"]', 
'Between Java and Lombok', 1, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Bali: The Island of Gods'), 
'multiple_choice', 
'Which of the following is NOT mentioned as a famous temple in Bali?', 
'["Tanah Lot", "Uluwatu", "Besakih", "Prambanan"]', 
'Prambanan', 2, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Bali: The Island of Gods'), 
'true_false', 
'Bali is known as the "Island of Gods."', 
NULL, 
'True', 3, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Bali: The Island of Gods'), 
'essay', 
'What makes Bali attractive to different types of travelers?', 
NULL, 
'Bali offers stunning beaches, rich culture, spiritual atmosphere, beautiful temples, lush rice terraces, traditional arts, and delicious local cuisine.', 4, NOW(), NOW()),

-- SOAL CHAPTER 5: Niagara Falls
((SELECT id FROM reading_materials WHERE title = 'Niagara Falls: A Natural Wonder'), 
'multiple_choice', 
'How many waterfalls make up Niagara Falls?', 
'["Two", "Three", "Four", "Five"]', 
'Three', 1, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Niagara Falls: A Natural Wonder'), 
'multiple_choice', 
'What is the total height of Niagara Falls?', 
'["157 feet", "167 feet", "177 feet", "187 feet"]', 
'167 feet', 2, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Niagara Falls: A Natural Wonder'), 
'true_false', 
'Niagara Falls attracts over 30 million visitors annually.', 
NULL, 
'True', 3, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'Niagara Falls: A Natural Wonder'), 
'essay', 
'Explain two important functions of Niagara Falls besides tourism.', 
NULL, 
'Niagara Falls serves as an important source of hydroelectric power, generating electricity for both the United States and Canada, and it plays a role in the ecosystem as part of the Great Lakes water system.', 4, NOW(), NOW()),

-- SOAL CHAPTER 6: Announcement
((SELECT id FROM reading_materials WHERE title = 'School Announcement: Science Fair Competition'), 
'multiple_choice', 
'When will the Science Fair Competition be held?', 
'["April 15-16, 2024", "April 20-21, 2024", "April 25-26, 2024", "May 20-21, 2024"]', 
'April 20-21, 2024', 1, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'School Announcement: Science Fair Competition'), 
'multiple_choice', 
'What is the registration deadline?', 
'["March 5, 2024", "April 1, 2024", "April 5, 2024", "April 10, 2024"]', 
'April 5, 2024', 2, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'School Announcement: Science Fair Competition'), 
'true_false', 
'The maximum number of students per team is 3.', 
NULL, 
'True', 3, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'School Announcement: Science Fair Competition'), 
'fill_in_blank', 
'The registration fee is _____ per team.', 
NULL, 
'$10', 4, NOW(), NOW()),

((SELECT id FROM reading_materials WHERE title = 'School Announcement: Science Fair Competition'), 
'essay', 
'List the four competition categories mentioned in the announcement.', 
NULL, 
'1. Physics and Engineering, 2. Chemistry and Materials Science, 3. Biology and Environmental Science, 4. Mathematics and Computer Science', 5, NOW(), NOW());