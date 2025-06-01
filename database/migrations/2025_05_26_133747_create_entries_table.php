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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_competition_id')->constrained()->onDelete('cascade');
            $table->integer('net_score');
            $table->integer('gross_score');
            $table->decimal('playing_handicap', 4, 1);
            $table->json('hole_by_hole_scores')->nullable();
            $table->timestamp('played_at')->nullable();
            $table->boolean('verified')->default(false);
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
