<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_order_log', function(Blueprint $table){
            $table->increments('id');
            $table->integer('author_id')->unsigned();

            $table->string('field_changed')->nullable();
            $table->integer('fromto_id')->unsigned()->nullable();
            $table->string('fromto_type')->nullable();

            $table->integer('action_id')->unsigned();

            //PolyMorph relation Many to One
            $table->integer('loggable_id')->unsigned();
            $table->string('loggable_type');

            $table->dateTime('date');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('action_id')->references('id')->on('dev_order_log_action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_order_log');
    }
}
