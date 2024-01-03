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
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('complain_type_id');
            $table->unsignedBigInteger('source_id');
            $table->string('complain_by');
            $table->string('phone');
            $table->date('date');
            $table->string('action_by')->nullable();
            $table->text('assigned')->nullable();
            $table->text('document')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('complains');
    }
};
