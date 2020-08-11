<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('time');
            $table->string('A-1')->nullable();;
            $table->string('A-2')->nullable();;
            $table->string('B-1')->nullable();;
            $table->string('B-2')->nullable();;
            $table->string('C-1')->nullable();;
            $table->string('C-2')->nullable();;
            $table->string('C-3')->nullable();;
            $table->string('D-1')->nullable();;
            $table->string('D-2')->nullable();;
            $table->string('D-3')->nullable();;
            $table->string('D-4')->nullable();;
            $table->string('D-5')->nullable();;
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
        Schema::dropIfExists('seats');
    }
}
