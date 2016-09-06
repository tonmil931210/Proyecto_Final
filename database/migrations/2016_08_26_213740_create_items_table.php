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
            $table -> integer('recorder');
            $table -> integer('min_stock');
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
        Schema::dropIfExists('items');
    }
}
