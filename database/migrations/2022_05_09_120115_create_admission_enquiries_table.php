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
        Schema::create('admission_enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address_line1',400);
            $table->string('address_line2',300)->nullable();
            $table->string('area',300);
            $table->string('location')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city',50);
            $table->string('state',50);
            $table->string('country',50);
            $table->string('pincode',8);
            $table->text('note')->nullable();
            $table->integer('no_of_child')->nullable();
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
        Schema::dropIfExists('admission_enquiries');
    }
};
