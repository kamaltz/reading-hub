<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            // # PERBAIKAN: Menambahkan kolom 'correct_answer' setelah kolom 'options'
            // Kolom ini bisa null karena soal esai tidak punya kunci jawaban.
            $table->string('correct_answer')->nullable()->after('options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            // Ini akan menghapus kolom jika migrasi di-rollback
            $table->dropColumn('correct_answer');
        });
    }
};