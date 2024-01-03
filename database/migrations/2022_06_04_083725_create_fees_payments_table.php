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
        Schema::create('fees_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('fees_master_id');
            $table->unsignedBigInteger('fee_id');
            $table->unsignedBigInteger('admission_id');
            $table->string('receipt_number', 20);
            $table->string('invoice_number', 20);
            $table->float('amount_paid');
            $table->float('discount_amount');
            $table->float('fine_amount');
            $table->enum('payment_mode', ['cash', 'cheque', 'online', 'card', 'dd']);
            $table->enum('status', ['unpaid', 'paid']);
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
        Schema::dropIfExists('fees_payments');
    }
};
