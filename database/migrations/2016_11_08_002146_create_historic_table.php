<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historic', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('name_item');
            $table -> integer('item_id');
            $table -> integer('number');
            $table -> string('type');
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
        Schema::dropIfExists('historic');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
