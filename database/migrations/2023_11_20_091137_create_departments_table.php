<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('college_id');
            $table->string('name')->unique();
            $table->string('image');
            $table->string('department_id')->unique();
            $table->string('description');
            $table->enum('is_deleted', ['yes', 'no'])->default('no');
            $table->enum('is_active', ['yes', 'no'])->default('no');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            // Add foreign key after the 'departments' table is created
            $table->foreign('college_id')->references('college_id')->on('colleges');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
