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
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('staff_id');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('office_location')->nullable();
            $table->foreign('staff_id')->references('staff_id')->on('staff');
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselors');
    }
};
