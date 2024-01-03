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
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('name', 50);
            $table->string('phone',12);
            $table->date('date');
            $table->date('next_date')->nullable();
            $table->string('call_duration_minute')->nullable();
            $table->string('call_duration_seconds')->nullable();
            $table->enum('call_type',['incoming','outgoing'])->default('incoming');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('call_logs');
    }
};
