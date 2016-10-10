<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevOrderDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_order_delivery', function( Blueprint $table ){
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('delivery_type_id')->unsigned();
            $table->string('delivery_f_name');
            $table->string('delivery_l_name');
            $table->string('delivery_phone');
            $table->string('delivery_address');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')->on('dev_order_index')
                ->onDelete('cascade');

            $table->foreign('delivery_type_id')
                ->references('id')->on('dev_delivery_types')
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
        Schema::drop('dev_order_delivery');
    }
}
