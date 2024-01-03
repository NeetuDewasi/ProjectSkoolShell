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
        Schema::create('add_exam_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('examgroup_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('subject_id');
            $table->date('exam_date');
            $table->time('exam_time');
            $table->string('duration', 20);
            $table->string('room_no', 20);
            $table->string('max_marks', 10);
            $table->string('min_marks', 10);
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted', 'published', 'unpublished'])->default('activated');
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
        Schema::dropIfExists('add_exam_subjects');
    }
};
