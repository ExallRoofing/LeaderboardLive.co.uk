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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('tees')->default('White');
            $table->unsignedTinyInteger('par');
            $table->decimal('sss', 4, 1)->nullable();
            $table->unsignedTinyInteger('holes')->default(18);
            $table->unsignedInteger('yardage')->nullable();
            $table->decimal('rating', 4, 1)->nullable();
            $table->unsignedSmallInteger('slope_rating')->nullable();
            $table->json('hole_data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
