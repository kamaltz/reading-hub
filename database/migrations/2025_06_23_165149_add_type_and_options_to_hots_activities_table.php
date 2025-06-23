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
            // Menambah kolom untuk tipe soal (essay/pilihan ganda)
            $table->string('type')->default('essay')->after('question');
            // Menambah kolom untuk menyimpan opsi jawaban (dalam format JSON)
            $table->json('options')->nullable()->after('type');
            // Menambah kolom untuk kunci jawaban pilihan ganda
            $table->string('answer_key')->nullable()->after('options');
            // Mengubah kolom 'answer' agar bisa null (karena akan dipakai untuk essay saja)
            $table->text('answer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            $table->dropColumn(['type', 'options', 'answer_key']);
            $table->text('answer')->nullable(false)->change();
        });
    }
};