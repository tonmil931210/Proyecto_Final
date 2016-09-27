<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetornableOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retornable_orders', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('order_id') -> unsigned();
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
        Schema::dropIfExists('retornable_orders');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
