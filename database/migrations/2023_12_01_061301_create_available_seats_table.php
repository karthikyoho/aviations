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
        Schema::create('available_seats', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('college_id');
            $table->unsignedBigInteger('total_seats');
            $table->unsignedBigInteger('available_seats');
            $table->unsignedSmallInteger('year')->default(now()->year); 
            $table->unsignedBigInteger('allocate_seats');
            $table->foreign('college_id')->references('college_id')->on('colleges');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_seats');
    }
};
