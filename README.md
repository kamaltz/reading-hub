Tutorial Instalasi Proyek Reading Hub (Laravel)
Dokumen ini akan memandu Anda melalui proses untuk mengkloning (clone), mengkonfigurasi, dan menjalankan proyek Laravel "Reading Hub" di komputer lokal Anda.

Prasyarat (Perangkat Lunak yang Dibutuhkan)
Sebelum memulai, pastikan Anda memiliki lingkungan pengembangan yang siap. Kami sangat merekomendasikan penggunaan Laragon karena sudah mencakup hampir semua yang Anda butuhkan dalam satu paket instalasi.

Opsi 1: Instalasi Menggunakan Laragon (Sangat Direkomendasikan)
Laragon adalah lingkungan pengembangan lokal portabel, terisolasi, cepat, dan kuat untuk PHP, Node.js, Python, Java, Go, Ruby. Laragon sudah mencakup Git, PHP, Composer, server database (MySQL), dan terminal yang terintegrasi.

Unduh dan Instal Laragon:

Kunjungi situs web resmi Laragon: https://laragon.org/download/

Unduh versi Laragon - Full.

Jalankan installer dan ikuti petunjuk di layar. Disarankan untuk tidak menginstalnya di direktori C:\Program Files untuk menghindari masalah perizinan. Gunakan direktori seperti C:\laragon.

Jalankan Laragon:

Setelah instalasi selesai, buka Laragon.

Klik tombol "Start All". Ini akan menjalankan server web Apache/Nginx dan server database MySQL.

Buka Terminal Laragon:

Klik tombol "Terminal" di jendela utama Laragon. Terminal ini sudah memiliki akses ke PHP, Composer, Git, dan Node.js/NPM.

Semua perintah selanjutnya dalam tutorial ini harus dijalankan melalui Terminal Laragon ini.

Dengan menggunakan Laragon, Anda dapat melewatkan instalasi manual untuk Git, PHP, Composer, dan server database.

Opsi 2: Instalasi Manual
Jika Anda tidak menggunakan Laragon, pastikan Anda telah menginstal perangkat lunak berikut secara terpisah:

Git: Untuk mengkloning repositori. Unduh Git

PHP: Versi 8.1 atau lebih baru. Unduh PHP

Composer: Manajer dependensi untuk PHP. Unduh Composer

Node.js & NPM: Untuk mengelola dependensi JavaScript. Unduh Node.js

Database Server: Seperti MySQL atau MariaDB (misalnya dari XAMPP).

Langkah 1: Clone Repositori dari Git
Buka Terminal Laragon (atau terminal biasa jika tidak memakai Laragon), navigasikan ke direktori www di dalam folder instalasi Laragon (cd C:/laragon/www), lalu jalankan perintah berikut. Ganti [URL_REPOSITORY_ANDA] dengan URL repositori Git proyek Anda.

git clone [URL_REPOSITORY_ANDA] reading-hub

Setelah selesai, masuk ke direktori proyek yang baru dibuat:

cd reading-hub

Langkah 2: Instal Dependensi PHP
Gunakan Composer untuk menginstal semua pustaka PHP yang dibutuhkan.

composer install

Langkah 3: Instal Dependensi JavaScript
Selanjutnya, instal semua paket JavaScript yang dibutuhkan menggunakan NPM.

npm install

Langkah 4: Konfigurasi File Lingkungan (.env)
Salin file .env.example menjadi file baru bernama .env.

cp .env.example .env

Langkah 5: Buat Kunci Aplikasi (Application Key)
Jalankan perintah Artisan berikut untuk membuat kunci enkripsi yang unik.

php artisan key:generate

Langkah 6: Konfigurasi Database
Jika menggunakan Laragon: Klik tombol "Database" di jendela Laragon. Ini akan membuka HeidiSQL.

Di HeidiSQL, klik kanan di panel kiri -> Create new -> Database.

Beri nama database, contohnya: reading_hub_db.

Buka file .env dengan editor teks.

Sesuaikan konfigurasi database. Untuk Laragon, username default adalah root dan password kosong.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reading_hub_db // Ganti dengan nama database Anda
DB_USERNAME=root // Username default Laragon
DB_PASSWORD= // Password default Laragon kosong

Langkah 7: Jalankan Migrasi Database
Setelah database dikonfigurasi, jalankan perintah migrasi untuk membuat semua tabel.

php artisan migrate

Catatan: Jika Anda ingin menjalankan migrasi dari awal dan menghapus semua data, gunakan php artisan migrate:fresh.

Langkah 8: Hubungkan Penyimpanan (Storage)
Buat tautan simbolis (symbolic link) agar file yang diunggah dapat diakses dari web.

php artisan storage:link

Langkah 9: Jalankan Server Pengembangan
Sekarang, Anda siap untuk menjalankan aplikasi!

Jalankan server PHP Laravel:

php artisan serve

Jalankan Vite untuk kompilasi aset (CSS & JS): Buka Terminal Laragon baru, navigasikan ke direktori proyek (cd C:/laragon/www/reading-hub), dan jalankan:

npm run dev

Setelah kedua server berjalan, buka browser Anda dan kunjungi alamat yang diberikan oleh php artisan serve (biasanya http://127.0.0.1:8000).
