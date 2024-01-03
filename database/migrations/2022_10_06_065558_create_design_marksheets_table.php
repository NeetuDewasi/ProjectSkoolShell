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
        Schema::create('design_marksheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('exam_id');
            $table->string('template',250);
            $table->string('heading', 250);
            $table->string('title', 250);
            $table->text('school_name', 250);
            $table->string('exam_center', 250);
            $table->string('body_text', 250);
            $table->string('footer_text', 250)->nullable();
            $table->string('printing_date', 250)->nullable();
            $table->tinyInteger('student_name');
            $table->tinyInteger('father_name');
            $table->tinyInteger('mother_name');
            $table->tinyInteger('exam_session');
            $table->tinyInteger('date_of_birth')->nullable();
            $table->tinyInteger('admission_number')->nullable();
            $table->tinyInteger('division')->nullable();
            $table->tinyInteger('roll_no');
            $table->tinyInteger('photo')->nullable();
            $table->tinyInteger('class');
            $table->tinyInteger('section');
            $table->tinyInteger('remark')->nullable();
            $table->text('background_image')->nullable();
            $table->text('left_logo')->nullable();
            $table->text('right_logo')->nullable();
            $table->text('left_sign')->nullable();
            $table->text('middle_sign')->nullable();
            $table->text('right_sign')->nullable();
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
        Schema::dropIfExists('design_marksheets');
    }
};
