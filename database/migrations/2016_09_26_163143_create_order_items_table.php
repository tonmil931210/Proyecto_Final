<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('item_id') -> unsigned();
            $table -> integer('order_id') -> unsigned();
            $table -> integer('number');
            $table -> date('date');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('order_items');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
