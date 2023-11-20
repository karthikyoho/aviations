<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('father_occupation');
            $table->string('Height');
            $table->string('weight');
            $table->enum('gender',['male','female'])->default('male');
            $table->string('marital_status');
            $table->string('age');
            $table->date('DOB');
            $table->string('SSLC mark');
            $table->string('HSC mark');
            $table->json('files');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->enum('passport',['yes','no']);
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('is_active',['yes','no'])->default('yes');
            $table->enum('is_deleted',['yes','no'])->default('no');
             $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
