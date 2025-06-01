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
        Schema::create('competition_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained('club_competitions')->onDelete('cascade');
            $table->string('file_path');
            $table->string('caption')->nullable();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_media');
    }
};
