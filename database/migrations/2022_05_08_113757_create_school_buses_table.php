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
        Schema::create('school_buses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('bus_number', 20);
            $table->string('vehicle_name', 60)->nullable();
            $table->string('vehicle_number', 20)->nullable();
            $table->date('insurance_date', 20)->nullable();
            $table->date('puc_date', 20)->nullable();
            $table->date('service_date', 20)->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted'])->default('pending');
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

        Schema::dropIfExists('school_buses');
    }
};
