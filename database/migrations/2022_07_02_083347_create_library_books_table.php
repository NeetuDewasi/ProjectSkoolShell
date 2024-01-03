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
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('reck_id');
            $table->integer('shelf_number');
            $table->string('code');
            $table->string('title');
            $table->string('author');
            $table->float('cost');
            $table->float('fine')->nullable();
            $table->date('inventory_date');
            $table->text('cover');
            $table->string('isbn_number')->nullable();
            $table->string('quantity');
            $table->string('publisher')->nullable();
            $table->enum('status', ['pending', 'activated', 'deactivated', 'deleted'])->default('activated');
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
        Schema::dropIfExists('library_books');
    }
};
