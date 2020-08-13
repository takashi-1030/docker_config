<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReserveSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve_seats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seat');
            $table->integer('reserve_id')->unsigned();
            $table->timestamps();

            $table->foreign('reserve_id')
                  ->references('id')
                  ->on('reserves')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve_seats');
    }
}
