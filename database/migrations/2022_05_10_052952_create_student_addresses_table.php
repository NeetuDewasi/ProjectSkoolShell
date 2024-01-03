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
        Schema::create('student_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('admission_id');
            $table->tinyInteger('isCurrent')->nullable();
            $table->tinyInteger('isPermanent')->nullable();
            $table->string('permanent_address_line1', 400);
            $table->string('permanent_address_line2', 300)->nullable();
            $table->string('permanent_location', 100)->nullable();
            $table->string('permanent_landmark', 100)->nullable();;
            $table->string('permanent_city', 100);
            $table->string('permanent_pincode', 10);
            $table->string('permanent_state', 100);
            $table->string('permanent_country', 100);
            $table->string('current_address_line1', 400);
            $table->string('current_address_line2', 300)->nullable();
            $table->string('current_location', 100)->nullable();
            $table->string('current_landmark', 100)->nullable();;
            $table->string('current_city', 100);
            $table->string('current_pincode', 10);
            $table->string('current_state', 100);
            $table->string('current_country', 100);
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted'])->default('activated');
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
        Schema::dropIfExists('student_addresses');
    }
};
