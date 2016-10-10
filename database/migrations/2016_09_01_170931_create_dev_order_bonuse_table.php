<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevOrderBonuseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_order_index_bonus', function(Blueprint $table){
            $table->increments('id');
            $table->integer('bonus_count');

            $table->integer('dev_order_index_id')->unsigned();
            $table->foreign('dev_order_index_id')->references('id')->on('dev_order_index');

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
        Schema::drop('dev_order_index_bonus');
    }
}
