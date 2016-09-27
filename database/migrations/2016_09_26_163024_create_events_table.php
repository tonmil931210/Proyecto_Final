<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('name') -> unique();
            $table -> date('start_date');
            $table -> date('finish_date');
            $table -> time('start_time');
            $table -> time('finish_time');
            $table -> string('location');
            $table -> string('place');
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
        Schema::dropIfExists('events');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        
    }
}
