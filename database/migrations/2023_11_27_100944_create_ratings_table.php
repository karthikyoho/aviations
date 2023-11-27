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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();  $table->unsignedBigInteger('college_id');
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            $table->double('rating', 10, 2); // Change data type to double(10,2)
            $table->text('comment')->nullable();
            $table->enum('is_deleted', ['yes', 'no'])->default('no');
            $table->enum('is_active', ['yes', 'no'])->default('yes');
          
            $table->timestamps();

           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
