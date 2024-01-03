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
        Schema::create('print_admit_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('school_section_id');
            $table->unsignedBigInteger('admit_card_id');
            $table->unsignedBigInteger('admission_id');
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted',]);
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
        Schema::dropIfExists('print_admit_cards');
    }
};
