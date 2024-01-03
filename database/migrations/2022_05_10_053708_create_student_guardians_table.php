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
        Schema::create('student_guardians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('admission_id');
            $table->enum('if_guardian_is', ['father', 'mother', 'other'])->default('father');
            $table->string('father_first_name', 100);
            $table->string('father_middle_name',  100)->nullable();
            $table->string('father_last_name',  100);
            $table->string('father_mobile', 20);
            $table->string('father_alternative_mobile', 20)->nullable();;
            $table->string('father_occupation');
            $table->text('father_email', 100)->nullable();
            $table->text('father_alternate_email', 100)->nullable();
            $table->text('father_photo')->nullable();;
            $table->string('mother_first_name', 100);
            $table->string('mother_middle_name', 100)->nullable();
            $table->string('mother_last_name', 100)->nullable();
            $table->string('mother_mobile', 50);
            $table->string('mother_alternative_mobile', 10)->nullable();
            $table->string('mother_occupation', 50)->nullable();
            $table->text('mother_email', 100)->nullable();
            $table->text('mother_alternate_email', 100)->nullable();
            $table->text('mother_photo')->nullable();;
            $table->string('guardian_first_name', 100)->nullable();
            $table->string('guardian_middle_name', 100)->nullable();
            $table->string('guardian_last_name', 100)->nullable();
            $table->string('guardian_mobile', 20)->nullable();
            $table->string('guardian_alternative_mobile', 20)->nullable();
            $table->text('guardian_occupation')->nullable();
            $table->text('guardian_email', 100)->nullable();
            $table->text('guardian_alternate_email', 100)->nullable();
            $table->text('guardian_photo')->nullable()->nullable();
            $table->text('guardian_relation', 100)->nullable();
            $table->string('address_line1', 400);
            $table->string('address_line2', 300)->nullable();
            $table->string('location')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city', 50);
            $table->string('pincode', 10);
            $table->string('state', 50);
            $table->string('country', 50);
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
        Schema::dropIfExists('student_guardians');
    }
};
