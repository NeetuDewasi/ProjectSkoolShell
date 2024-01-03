<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('school_section_id');
            $table->unsignedBigInteger('student_category_id');
            $table->unsignedBigInteger('student_house_id')->nullable();
            $table->string('admission_number');
            $table->string('roll_number');
            $table->date('admission_date', 10);
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->date('date_of_birth', 20);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('religion', 100);
            $table->string('cast', 100);
            $table->string('mobile', 20);
            $table->string('email');
            $table->text('student_photo');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-', 'K+', 'K-', 'Other']);
            $table->string('height', 50)->nullable();
            $table->string('weight', 50)->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted', 'ex-student'])->default('activated');
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
        Schema::dropIfExists('admissions');
    }
};
