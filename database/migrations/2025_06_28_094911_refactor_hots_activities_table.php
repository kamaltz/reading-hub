<?php

// database/migrations/xxxx_xx_xx_xxxxxx_refactor_hots_activities_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            // Menambahkan kolom judul dan deskripsi setelah 'id'
            $table->string('title')->after('id');
            $table->text('description')->nullable()->after('title');

            // 1. Menambahkan foreign key ke chapters sesuai permintaan baru
            $table->foreignId('chapter_id')
                  ->after('id') // Atur posisi kolom
                  ->constrained('chapters')
                  ->onDelete('cascade');

            // 2. Hapus foreign key dan kolom reading_material_id
            $table->dropForeign(['reading_material_id']);
            $table->dropColumn('reading_material_id');

            // 3. Hapus kolom correct_answer karena akan ditangani oleh tabel 'options'
            $table->dropColumn('correct_answer');
        });
    }

    public function down(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            // Logika untuk mengembalikan perubahan jika diperlukan (rollback)
            $table->dropColumn(['title', 'description']);

            $table->dropForeign(['chapter_id']);
            $table->dropColumn('chapter_id');

            $table->foreignId('reading_material_id')->constrained('reading_materials');
            $table->text('correct_answer')->nullable();
        });
    }
};