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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('vehicle_no', 15)->comment('assign or insert by school (eg. 1,2,3)');
            $table->string('registration_no')->comment('vehicle registration number');
            $table->date('insurance_date')->comment('insurance end date');
            $table->date('puc_date')->comment('PUC end date');
            $table->date('service_date');
            $table->string('vehicle_model', 50)->comment('vehicle company name');
            $table->string('model_year');
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'activated', 'deleted', 'deactivated'])->default('activated');
            $table->json('detail')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
};
