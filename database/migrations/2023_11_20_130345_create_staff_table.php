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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('college_id');
            $table->string('staff_name');
            $table->string('staff_id')->unique();
            $table->enum('is_active',['yes','no'])->default('yes');
            $table->enum('is_deleted',['yes','no'])->default('no'); 
            $table->foreign('college_id')->references('college_id')->on('colleges');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
