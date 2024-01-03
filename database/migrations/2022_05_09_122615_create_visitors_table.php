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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('purpose_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('id_card');
            $table->integer('no_of_person');
            $table->date('date');
            $table->time('in_time', $precision = 0);
            $table->time('out_time', $precision = 0);
            $table->text('document')->nullable();
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
        Schema::dropIfExists('visitors');
    }
};
