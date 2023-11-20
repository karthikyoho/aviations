
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('college_id');
            $table->string('department_id');
            $table->string('course_id')->unique();
            $table->string('name')->unique();
            $table->string('description');
            $table->string('course_duration');
            $table->unsignedBigInteger('total_seats');
            $table->unsignedBigInteger('available_seats');
            $table->string('image');
            $table->enum('is_deleted', ['yes', 'no'])->default('no');
            $table->enum('is_active', ['yes', 'no'])->default('no');
            $table->foreign('college_id')->references('college_id')->on('colleges');
            $table->foreign('department_id')->references('department_id')->on('departments');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        
            
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