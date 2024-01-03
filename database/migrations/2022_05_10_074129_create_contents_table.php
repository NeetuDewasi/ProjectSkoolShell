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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_class_id')->nullable();
            $table->unsignedBigInteger('school_section_id')->nullable();
            $table->string('content_type', 255);
            $table->string('title', 50);
            $table->json('content_for')->nullable();
            $table->tinyInteger('is_publish')->nullable();
            $table->date('published_at')->nullable();
            $table->text('description')->nullable();
            $table->json('documents')->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted','published','unpublished'])->default('activated');
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
        Schema::dropIfExists('contents');
    }
};
