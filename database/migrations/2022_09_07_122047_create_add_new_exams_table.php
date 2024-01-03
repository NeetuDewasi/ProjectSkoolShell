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
        Schema::create('add_new_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('exam_group_id');
            $table->string('exam_name', 200);
            $table->boolean('publish');
            $table->boolean('publish_result');
            $table->enum('roll_no', ['admitCard_rollNo', 'profile_rollNo']);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('add_new_exams');
    }
};
