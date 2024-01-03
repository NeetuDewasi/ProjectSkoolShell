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
        Schema::create('hostel_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('class');
            $table->string('section');
            $table->string('admission_number');
            $table->string('student_name');
            $table->string('mobile_number');
            $table->string('guardian_number');
            $table->string('hostel_name');
            $table->string('room_number');
            $table->string('room_type');
            $table->string('cost_per_bed');
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
        Schema::dropIfExists('hostel_reports');
    }
};
