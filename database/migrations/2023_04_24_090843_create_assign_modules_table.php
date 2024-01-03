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
        Schema::create('assign_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_group_id');
            $table->unsignedBigInteger('school_id');
            $table->json('name');
            $table->enum('status',['activated','deactivated','deleted']);
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
        Schema::dropIfExists('assign_modules');
    }
};
