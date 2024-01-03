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
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('hostel_name', 100);
            $table->enum('type', ['boys', 'girls', 'combine',])->default('boys');
            $table->integer('intake');
            $table->string('contact_person', 60);
            $table->string('contact_number', 20);
            $table->string('alternative_contact_number', 20)->nullable();
            $table->string('email');
            $table->string('address_line1', 400);
            $table->string('address_line2', 300)->nullable();
            $table->string('area');
            $table->string('landmark')->nullable();
            $table->string('city', 50);
            $table->string('pincode', 10);
            $table->string('state', 50);
            $table->string('country', 50);
            $table->text('description')->nullable();
            $table->text('deatils')->nullable();
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
        Schema::dropIfExists('hostels');
    }
};
