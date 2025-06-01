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
        Schema::table('tournament_weeks', function (Blueprint $table) {
            $table->string('week_number')->change(); // Change from int to string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_weeks', function (Blueprint $table) {
            $table->unsignedInteger('week_number')->change(); // Revert if needed
        });
    }
};
