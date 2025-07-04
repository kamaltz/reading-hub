# Upload Materi Bahasa Inggris Bab 1-6

Dokumentasi ini menjelaskan cara mengupload materi dari Bab 1-6 beserta soal-soalnya ke dalam database Reading Hub.

## Struktur Materi yang Diupload

### Bab 1: Great Athletes (Descriptive Text)
- **Materi**: Cristiano Ronaldo: The Football Legend
- **Jenis Soal**: 5 soal (Multiple Choice, True/False, Essay, Fill in Blank)

### Bab 2: Sports Events (Recount Text)  
- **Materi**: My Experience at the School Sports Day
- **Jenis Soal**: 4 soal (Multiple Choice, True/False, Essay)

### Bab 3: What Are You Going to Do Today? (Procedure Text)
- **Materi**: How to Start Your Day Productively
- **Jenis Soal**: 3 soal (Multiple Choice, True/False, Essay)

### Bab 4: Which One Is Your Best Getaway? (Descriptive Text)
- **Materi**: Bali: The Island of Gods
- **Jenis Soal**: 4 soal (Multiple Choice, True/False, Essay)

### Bab 5: Let's Visit Niagara Falls (Report Text)
- **Materi**: Niagara Falls: A Natural Wonder
- **Jenis Soal**: 4 soal (Multiple Choice, True/False, Essay)

### Bab 6: Giving Announcement (Announcement Text)
- **Materi**: School Announcement: Science Fair Competition
- **Jenis Soal**: 5 soal (Multiple Choice, True/False, Fill in Blank, Essay)

## Cara Upload

### Metode 1: Menggunakan Laravel Seeder (Direkomendasikan)

1. **Jalankan seeder khusus untuk Bab 1-6:**
   ```bash
   php artisan db:seed --class=EnglishTextbookSeeder
   ```

2. **Atau jalankan semua seeder:**
   ```bash
   php artisan db:seed
   ```

3. **Menggunakan script otomatis:**
   ```bash
   ./upload_textbook_content.sh
   ```

### Metode 2: Menggunakan SQL Langsung

1. **Import file SQL ke database:**
   ```bash
   mysql -u root -p reading_hub_db < database/sql/english_textbook_chapters_1_6.sql
   ```

2. **Atau melalui phpMyAdmin/HeidiSQL:**
   - Buka file `database/sql/english_textbook_chapters_1_6.sql`
   - Copy paste isi file ke SQL editor
   - Jalankan query

## File yang Dibuat

1. **`database/seeders/EnglishTextbookSeeder.php`** - Laravel seeder untuk Bab 1-6
2. **`database/sql/english_textbook_chapters_1_6.sql`** - File SQL untuk import langsung
3. **`upload_textbook_content.sh`** - Script bash untuk menjalankan upload
4. **`UPLOAD_MATERI_BAB_1_6.md`** - Dokumentasi ini

## Struktur Database

### Tabel yang Terpengaruh:
- **`genres`** - Jenis teks (Narrative, Descriptive, Procedure, dll)
- **`chapters`** - Bab 1-6 
- **`reading_materials`** - Materi bacaan untuk setiap bab
- **`hots_activities`** - Soal-soal untuk setiap materi

### Jenis Soal yang Didukung:
- `multiple_choice` - Pilihan ganda
- `true_false` - Benar/Salah
- `essay` - Esai
- `fill_in_blank` - Isi titik-titik

## Verifikasi Upload

Setelah upload, verifikasi dengan query berikut:

```sql
-- Cek jumlah chapters
SELECT COUNT(*) as total_chapters FROM chapters;

-- Cek jumlah materi per bab
SELECT c.title, COUNT(rm.id) as total_materials 
FROM chapters c 
LEFT JOIN reading_materials rm ON c.id = rm.chapter_id 
GROUP BY c.id, c.title;

-- Cek jumlah soal per materi
SELECT rm.title, COUNT(ha.id) as total_questions 
FROM reading_materials rm 
LEFT JOIN hots_activities ha ON rm.id = ha.reading_material_id 
GROUP BY rm.id, rm.title;
```

## Troubleshooting

### Error: Table doesn't exist
Pastikan migrasi sudah dijalankan:
```bash
php artisan migrate
```

### Error: Duplicate entry
Jika data sudah ada, hapus dulu atau gunakan `INSERT IGNORE` dalam SQL.

### Error: Foreign key constraint
Pastikan urutan insert benar: genres → chapters → reading_materials → hots_activities

## Total Data yang Diupload

- **6 Chapters** (Bab 1-6)
- **6 Reading Materials** (1 per bab)
- **25 HOTS Activities** (soal-soal)
- **6 Genres** (jenis teks)

Semua materi sudah disesuaikan dengan kurikulum Bahasa Inggris kelas X dan struktur database Reading Hub.