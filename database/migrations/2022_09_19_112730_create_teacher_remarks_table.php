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
        Schema::create('teacher_remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('examgroup_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('admission_id');
            $table->text('remarks');
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted', 'published', 'unpublished'])->default('activated');
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
        Schema::dropIfExists('teacher_remarks');
    }
};
