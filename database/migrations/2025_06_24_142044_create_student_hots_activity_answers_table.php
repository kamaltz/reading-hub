<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_hots_activity_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hots_activity_id')->constrained()->onDelete('cascade');
            $table->text('student_answer')->nullable(); // Jawaban bisa panjang (untuk esai) atau kosong.
            $table->boolean('is_correct')->nullable(); // Bisa null untuk esai yang belum dinilai.
            $table->unsignedInteger('score')->default(0);
            $table->timestamps();

            // Tambahkan unique constraint agar siswa hanya bisa menjawab satu aktivitas sekali.
            $table->unique(['user_id', 'hots_activity_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_hots_activity_answers');
    }
};