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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('expense_head_id');
            $table->string('name');
            $table->string('invoice_no');
            $table->string('amount');
            $table->date('date');
            $table->text('description')->nullable();
            $table->longText('documents')->nullable();
            $table->longText('details')->nullable();
            $table->enum('status',['activated','deactivated','deleted'])->default('activated');
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
        Schema::dropIfExists('expenses');
    }
};
