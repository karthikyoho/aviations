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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registered_id')->unique();
            $table->string('profile_image');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->enum('1st_priority',['Air Hosters','Aviation Management','Pilot','Cabin Crew', 'Flight Dispatch Operation','Passenger Service Agent','Galileo GDS','Drone Training'])->default('Air Hosters');
            $table->enum('2nd_priority',['Air Hosters','Aviation Management','Pilot','Cabin Crew', 'Flight Dispatch Operation','Passenger Service Agent','Galileo GDS','Drone Training'])->default('Drone Training');
            $table->enum('3rd_priority',['Air Hosters','Aviation Management','Pilot','Cabin Crew', 'Flight Dispatch Operation','Passenger Service Agent','Galileo GDS','Drone Training'])->default('Galileo GDS');
            $table->string('preferred_location1');
            $table->string('preferred_location2');
            $table->string('otp',6)->nullable();
            $table->enum('is_admin',['yes','no'])->default('no');
            $table->enum('is_deleted', ['yes', 'no'])->default('no');
            $table->enum('is_active', ['yes', 'no'])->default('no');
          
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
