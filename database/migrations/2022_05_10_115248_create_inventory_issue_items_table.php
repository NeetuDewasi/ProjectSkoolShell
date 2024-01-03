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
        Schema::create('inventory_issue_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('login_user_id');
            $table->unsignedBigInteger('inventory_item_category_id');
            $table->unsignedBigInteger('inventory_add_item_id');
            $table->unsignedBigInteger('inventory_item_department_id');
            $table->unsignedBigInteger('inventory_item_employee_id');
            $table->integer('quantity');
            $table->date('return_date');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('inventory_issue_items');
    }
};
