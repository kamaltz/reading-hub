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
            $table->string('type')->default('essay'); // e.g., 'multiple_choice', 'essay'
            $table->json('options')->nullable(); // For multiple choice options
            $table->string('answer_key')->nullable(); // For multiple choice correct answer
            $table->text('answer')->nullable(); // For essay answers or general purpose
            $table->integer('sequence')->default(0);
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