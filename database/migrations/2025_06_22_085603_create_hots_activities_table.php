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
    Schema::create('hots_activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reading_material_id')->constrained()->onDelete('cascade');
        $table->text('question');
        $table->enum('type', ['multiple_choice', 'essay']);
        $table->json('options')->nullable(); // Untuk menyimpan pilihan A, B, C, D dalam format JSON
        $table->string('answer_key')->nullable(); // Untuk kunci jawaban pilihan ganda
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hots_activities');
    }
};