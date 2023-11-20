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
        Schema::create('counseling_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counselor_id');
            $table->string('student_id');
            $table->string('course_id');
            $table->dateTime('appointment_date');
            $table->text('notes')->nullable();

            $table->dateTime('appointment_time');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->foreign('counselor_id')->references('id')->on('counselors');
            $table->foreign('student_id')->references('student_id')->on('students');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counseling_appointments');
    }
};
