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
        // Ganti 'activities' jika Anda menamai tabelnya hots_activities
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            // PERBAIKI BARIS INI
            // Pastikan 'reading_materials' adalah nama tabel yang benar
            $table->foreignId('material_id')->constrained('reading_materials')->onDelete('cascade');
            
            $table->foreignId('genre_id')->nullable()->constrained('genres')->onDelete('cascade');
            $table->text('question');
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->string('correct_answer')->nullable();
            $table->enum('type', ['multiple_choice', 'essay']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ganti 'activities' jika perlu
        Schema::dropIfExists('activities');
    }
};