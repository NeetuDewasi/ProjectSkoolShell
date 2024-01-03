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
        Schema::create('admit_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('exam_id');
            $table->string('template',250);
            $table->string('heading', 250);
            $table->string('title', 250);
            $table->text('school_name', 250);
            $table->string('exam_center', 250);
            $table->string('footer_text', 250)->nullable();
            $table->tinyInteger('student_name')->nullable();
            $table->tinyInteger('father_name')->nullable();
            $table->tinyInteger('mother_name')->nullable();
            $table->tinyInteger('date_of_birth')->nullable();
            $table->tinyInteger('admission_number');
            $table->tinyInteger('roll_no')->nullable();
            $table->tinyInteger('student_address')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('phone_number')->nullable();
            $table->tinyInteger('class')->nullable();
            $table->tinyInteger('section')->nullable();
            $table->text('background_image')->nullable();
            $table->text('signature')->nullable();
            $table->text('left_logo')->nullable();
            $table->text('right_logo')->nullable();
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
        Schema::dropIfExists('admit_cards');
    }
};
