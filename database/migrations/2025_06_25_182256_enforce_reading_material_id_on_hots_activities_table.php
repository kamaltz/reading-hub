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
            $table->unsignedBigInteger('reading_material_id')->nullable()->change();
            // Paksa kolom ini agar tidak boleh null (NOT NULL)
            $table->unsignedBigInteger('reading_material_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('reading_material_id')->nullable(false)->change();
            // Jika di-rollback, kembalikan menjadi boleh null (opsional)
            $table->unsignedBigInteger('reading_material_id')->nullable()->change();
        });
    }
};