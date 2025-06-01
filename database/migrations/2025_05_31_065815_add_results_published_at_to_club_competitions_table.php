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
        Schema::table('club_competitions', function (Blueprint $table) {
            $table->timestamp('results_published_at')->nullable()->after('competition_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('club_competitions', function (Blueprint $table) {
            $table->dropColumn('results_published_at');
        });
    }
};
