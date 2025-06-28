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
Schema::create('questions', function (Blueprint $table) {
    $table->id();
    // Pastikan foreign key mengarah ke tabel Anda: 'hots_activities'
    $table->foreignId('hots_activity_id')->constrained('hots_activities')->onDelete('cascade');
    $table->text('content');
    $table->enum('type', ['multiple_choice', 'essay', 'multiple_response', 'true_false', 'matching', 'fill_in_the_blank']);
    $table->integer('order')->default(0); // Untuk drag n drop
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};