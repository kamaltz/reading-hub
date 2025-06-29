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
            // This column is obsolete as questions are now handled in their own table.
            $table->dropColumn('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hots_activities', function (Blueprint $table) {
            $table->text('question')->after('description');
        });
    }
};