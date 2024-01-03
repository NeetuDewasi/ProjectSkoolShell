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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('first_name', 100);
            $table->string('middle_name', 60);
            $table->string('last_name', 60);
            $table->string('mobile', 20);
            $table->string('alternative_mobile', 20)->nullable();
            $table->string('email', 60);
            $table->string('alternative_email', 60)->nullable();
            $table->string('address_line1', 400);
            $table->string('address_line2', 300)->nullable();
            $table->string('location')->nullable();
            $table->string('landmark');
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
        Schema::dropIfExists('teachers');
    }
};
