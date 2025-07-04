# Reading Hub - Platform Pembelajaran Bahasa Inggris

Reading Hub adalah aplikasi web berbasis Laravel untuk pembelajaran Bahasa Inggris dengan fokus pada reading comprehension dan HOTS (Higher Order Thinking Skills) activities.

## Fitur Aplikasi

### Untuk Admin
- **Manajemen Konten**: Upload dan edit materi bacaan
- **Manajemen Soal**: Buat soal dengan berbagai jenis (Multiple Choice, Essay, True/False, Fill in Blank)
- **Manajemen Siswa**: Import siswa dari Excel, monitoring progress
- **Dashboard Analytics**: Statistik pembelajaran dan progress siswa
- **Manajemen Chapter**: Organisasi materi berdasarkan bab

### Untuk Siswa
- **Reading Materials**: Akses materi bacaan dengan berbagai genre
- **Interactive Exercises**: Kerjakan soal dengan feedback langsung
- **Progress Tracking**: Monitor kemajuan belajar pribadi
- **Responsive Design**: Akses dari desktop dan mobile

### Jenis Teks yang Didukung
- Narrative Text
- Descriptive Text
- Procedure Text
- Recount Text
- Report Text
- Announcement Text

## Instalasi

### Prasyarat
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

**Rekomendasi**: Gunakan [Laragon](https://laragon.org/download/) yang sudah include semua tools di atas.

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone [URL_REPOSITORY] reading-hub
   cd reading-hub
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=reading_hub_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Setup Database**
   ```bash
   php artisan migrate
   php artisan db:seed
   php artisan storage:link
   ```

6. **Jalankan Aplikasi**
   ```bash
   # Terminal 1
   php artisan serve
   
   # Terminal 2
   npm run dev
   ```

   Akses: http://127.0.0.1:8000

## Seeder yang Tersedia

### 1. DatabaseSeeder
Seeder utama yang menjalankan semua seeder lain:
```bash
php artisan db:seed
```

### 2. EducationalContentSeeder
Membuat data contoh:
- 5 Genre teks
- 6 Chapter contoh
- 3 Reading materials (Lake Toba, Borobudur, Fried Rice)
- 12 HOTS activities dengan berbagai jenis soal

### 3. EnglishTextbookSeeder
Konten lengkap Bab 1-6 Bahasa Inggris:
- Chapter 1: Great Athletes (Cristiano Ronaldo)
- Chapter 2: Sports Events (School Sports Day)
- Chapter 3: Daily Activities (Morning Routine)
- Chapter 4: Holiday Destinations (Bali)
- Chapter 5: Natural Wonders (Niagara Falls)
- Chapter 6: Announcements (Science Fair)
- Total: 25 soal dengan berbagai jenis

```bash
# Jalankan seeder khusus
php artisan db:seed --class=EnglishTextbookSeeder
```

### 4. Upload Materi Tambahan
Gunakan file SQL untuk import langsung:
```bash
mysql -u root -p reading_hub_db < database/sql/english_textbook_chapters_1_6.sql
```

## Detail Login

### Akun Default (Dibuat oleh DatabaseSeeder)

**Admin:**
- Email: `admin@readhub.my.id`
- Password: `password`
- Role: Admin
- Akses: Dashboard admin, manajemen konten, analytics

**Siswa:**
- Email: `siswa@readhub.my.id`
- Password: `password`
- Role: Student
- Akses: Materi bacaan, latihan soal, progress tracking

### Fitur Login
- **Session Management**: Auto logout setelah idle
- **Role-based Access**: Admin dan Student memiliki dashboard berbeda
- **Remember Me**: Opsi tetap login
- **Password Reset**: Fitur lupa password (perlu konfigurasi email)

### Import Siswa Massal
Admin dapat import siswa dari file Excel:
1. Login sebagai admin
2. Masuk ke menu "Students"
3. Klik "Import Students"
4. Upload file Excel dengan format: name, email, student_id

## Struktur Database

- `users` - Data pengguna (admin/siswa)
- `genres` - Jenis teks (narrative, descriptive, dll)
- `chapters` - Bab pembelajaran
- `reading_materials` - Materi bacaan
- `hots_activities` - Soal-soal latihan
- `student_hots_activity_answers` - Jawaban siswa
- `student_material_progress` - Progress belajar siswa

## Teknologi

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, TailwindCSS
- **Database**: MySQL
- **Build Tool**: Vite
- **Import/Export**: Maatwebsite Excel

## Support

Untuk bantuan teknis atau pertanyaan, silakan buat issue di repository ini.