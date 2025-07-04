#!/bin/bash

# Script untuk mengupload materi Bahasa Inggris Bab 1-6
echo "=== Upload Materi Bahasa Inggris Bab 1-6 ==="

# Opsi 1: Menggunakan Laravel Seeder
echo "Opsi 1: Menjalankan Laravel Seeder..."
php artisan db:seed --class=EnglishTextbookSeeder

echo ""
echo "=== Alternatif: Menggunakan SQL langsung ==="
echo "Jika ingin menggunakan SQL langsung, jalankan:"
echo "mysql -u [username] -p [database_name] < database/sql/english_textbook_chapters_1_6.sql"
echo ""
echo "Contoh:"
echo "mysql -u root -p reading_hub_db < database/sql/english_textbook_chapters_1_6.sql"
echo ""
echo "=== Selesai ==="