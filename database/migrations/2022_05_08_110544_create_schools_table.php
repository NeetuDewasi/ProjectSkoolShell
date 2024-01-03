<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_group_id');
            $table->string('name', 100);
            $table->string('contact_person_name', 60);
            $table->string('mobile', 20);
            $table->string('alternative_mobile', 20)->nullable();
            $table->string('email', 60);
            $table->string('alternative_email', 60)->nullable();
            $table->string('password', 60);
            $table->string('password_text', 60);
            $table->enum('is_same_address',['true','false'])->nullable();
            $table->string('current_address_line1', 400)->nullable();
            $table->string('current_address_line2', 300)->nullable();
            $table->string('current_location')->nullable();
            $table->string('current_landmark')->nullable();
            $table->string('current_city', 50)->nullable();
            $table->string('current_pincode', 10)->nullable();
            $table->string('current_state', 50)->nullable();
            $table->string('current_country', 50)->nullable();
            $table->string('permanent_address_line1', 400)->nullable();
            $table->string('permanent_address_line2', 300)->nullable();
            $table->string('permanent_location')->nullable();
            $table->string('permanent_landmark')->nullable();
            $table->string('permanent_city', 50)->nullable();
            $table->string('permanent_pincode', 10)->nullable();
            $table->string('permanent_state', 50)->nullable();
            $table->string('permanent_country', 50)->nullable();
            $table->string('activation_key')->nullable();
            $table->date('activation_start_date')->nullable();
            $table->date('activation_end_date')->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
};
