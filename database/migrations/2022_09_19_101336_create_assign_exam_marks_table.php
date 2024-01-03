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
        Schema::create('assign_exam_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('examgroup_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('addexam_subject_id');
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('school_section_id');
            $table->boolean('absent')->nullable();
            $table->string('obtained_marks', 10);
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted', 'completed'])->default('activated');
            $table->json('details')->nullable();
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
        Schema::dropIfExists('assign_exam_marks');
    }
};
