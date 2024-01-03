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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('certificate_name');
            $table->string('header_right_text')->nullable();
            $table->string('header_left_text')->nullable();
            $table->string('body_text');

            $table->string('footer_right_text')->nullable();
            $table->string('footer_left_text')->nullable();
            $table->string('footer_center_text')->nullable();
            $table->string('header_height')->nullable();
            $table->string('footer_height')->nullable();
            $table->string('body_width')->nullable();

            $table->string('body_height')->nullable();
            $table->tinyInteger('student_photo')->nullable();
            $table->text('background_image')->nullable();
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
        Schema::dropIfExists('certificates');
    }
};
