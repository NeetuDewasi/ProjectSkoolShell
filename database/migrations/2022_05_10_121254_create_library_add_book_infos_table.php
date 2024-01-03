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
        Schema::create('library_add_book_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('title',50);
            $table->string('book_number');
            $table->string('isbn_number');
            $table->string('publisher');
            $table->string('author');
            $table->string('subject');
            $table->string('rack_number');
            $table->text('quantity');
            $table->text('price');
            $table->date('post_date');
            $table->text('description');
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
        Schema::dropIfExists('library_add_book_infos');
    }
};
