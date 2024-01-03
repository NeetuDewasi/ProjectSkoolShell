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
        Schema::create('inventory_add_item_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('inventory_item_category_id');
            $table->unsignedBigInteger('inventory_add_item_id');
            $table->unsignedBigInteger('inventory_supplier_info_id');
            $table->unsignedBigInteger('inventory_item_store_id');
            $table->string('quantity');
            $table->date('income_date');
            $table->text('description')->nullable();
            $table->string('document');
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
        Schema::dropIfExists('inventory_add_item_stocks');
    }
};
