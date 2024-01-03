<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_id_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->text('school_name');
            $table->string('id_card_title');
            $table->string('header_color', 50);
            $table->text('address');
            $table->string('admission_number');
            $table->tinyInteger('student_name')->nullable();
            $table->tinyInteger('class')->nullable();
            $table->tinyInteger('father_name')->nullable();
            $table->tinyInteger('mother_name')->nullable();
            $table->tinyInteger('student_address')->nullable();
            $table->tinyInteger('phone_number')->nullable();
            $table->tinyInteger('date_of_birth')->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->tinyInteger('student_photo')->nullable();
            $table->text('background_image')->nullable();
            $table->text('signature')->nullable();
            $table->text('logo')->nullable();
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
        Schema::dropIfExists('student_id_cards');
    }
};
