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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('fees_master_id');
            $table->unsignedBigInteger('fee_discount_id')->nullable();
            $table->date('date');
            $table->string('amount');
            $table->string('discount_amount')->default(0);
            $table->string('fine_amount')->default(0);
            $table->text('payment_mode');
            $table->text('description')->nullable();
            $table->enum('status',['pending','activated','deactivated','deleted'])->default('pending');
            $table->enum('fee_status',['advance','unpaid','paid','partial'])->default('unpaid');
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
        Schema::dropIfExists('fees');
    }
};
