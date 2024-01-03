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
        Schema::create('student_other_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('admission_id')->nullable();
            $table->string('national_identification_number')->nullable();
            $table->string('local_identification_number')->nullable();
            $table->enum('rte', ['yes', 'no'])->default('no')->nullable();
            $table->string('previous_school')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted'])->default('activated')->nullable();
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
        Schema::dropIfExists('student_other_details');
    }
};
