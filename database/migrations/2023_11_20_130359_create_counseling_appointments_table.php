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
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->text('notes')->nullable();
            $table->dateTime('councelling_date');
            $table->enum('is_deleted', ['yes', 'no'])->default('no');
            $table->enum('is_active', ['yes', 'no'])->default('no');
          
            $table->enum('counselling_mode',['online','offline'])->default('online');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->foreign('counselor_id')->references('id')->on('counselors');
            $table->foreign('student_id')->references('student_id')->on('students');
        
            $table->timestamps();
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
