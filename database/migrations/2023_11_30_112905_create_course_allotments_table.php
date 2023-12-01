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
        Schema::create('course_allotments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('course_id');
            $table->string('college_id');
            $table->unsignedSmallInteger('year')->default(now()->year); 
            $table->foreign('student_id')->references('id')->on('students');
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
        Schema::dropIfExists('course_allotments');
    }
};
