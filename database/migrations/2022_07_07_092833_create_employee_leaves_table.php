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
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->dateTime('leave_from');
            $table->dateTime('leave_to');
            $table->text('leave_reason');
            $table->json('documents')->nullable();
            $table->unsignedBigInteger('response_by')->nullable();
            $table->dateTime('response_at')->nullable();
            $table->text('response_message')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'deleted'])->default('pending');
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
        Schema::dropIfExists('employee_leaves');
    }
};
