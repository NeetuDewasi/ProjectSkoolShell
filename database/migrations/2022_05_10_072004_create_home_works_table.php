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
        Schema::create('home_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('title',50);
            $table->json('homework_for')->nullable();
            $table->date('issuing_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->json('document')->nullable();
            $table->text('description')->nullable();
            $table->date('evaluation_date')->nullable();
            $table->enum('status',['pending','published','unpublished','deleted'])->default('pending');
            $table->json('details')->nullable()->comment('insert other field data');
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
        Schema::dropIfExists('home_works');
    }
};
