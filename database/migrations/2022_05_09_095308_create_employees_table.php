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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('department_id');
            $table->string('registration_id')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name',50)->nullable();
            $table->string('father_name',100);
            $table->string('mother_name',100)->nullable();
            $table->string('email',100);
            $table->enum('gender',['male','female','other'])->default('male');
            $table->date('dob')->nullable();
            $table->date('date_of_join');
            $table->string('mobile', 20)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('photo')->nullable();
            $table->text('current_address1',400)->nullable();
            $table->text('current_address2',300)->nullable();
            $table->text('current_area',300)->nullable();
            $table->string('current_location')->nullable();
            $table->string('current_landmark')->nullable();
            $table->string('current_city',50)->nullable();
            $table->string('current_state',50)->nullable();
            $table->string('current_country',50)->nullable();
            $table->string('current_pincode',8)->nullable();
            $table->boolean('is_same_address')->default(0);
            $table->text('permanent_address1',400)->nullable();
            $table->text('permanent_address2',300)->nullable();
            $table->text('permanent_area',300)->nullable();
            $table->string('permanent_location')->nullable();
            $table->string('permanent_landmark')->nullable();
            $table->string('permanent_city',50)->nullable();
            $table->string('permanent_state',50)->nullable();
            $table->string('permanent_country',50)->nullable();
            $table->string('permanent_pincode',8)->nullable();
            $table->enum('status',['pending','activated','deactivated','deleted'])->default('pending');
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
        Schema::dropIfExists('employees');
    }
};
