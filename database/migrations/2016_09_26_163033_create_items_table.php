<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table -> increments('id');
            $table -> integer('item_type_id') -> unsigned();      
            $table -> string('name') -> unique();
            $table -> float('price');
            $table -> integer('number');
            $table -> integer('number_on_hold')->default(0);
            $table -> integer('reorder');
            $table -> integer('min_stock');
            $table -> string('state')->default('no eliminado');
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
        Schema::dropIfExists('items');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
