<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_order_index_sub_product', function(Blueprint $table){
            $table->increments('id');
            $table->integer('dev_sub_product_id')->unsigned();
            $table->foreign('dev_sub_product_id')->references('id')->on('dev_sub_product');

            $table->integer('dev_order_index_id')->unsigned();
            $table->foreign('dev_order_index_id')->references('id')->on('dev_order_index');

            $table->integer('dev_order_status_list_id')->unsigned()->default(1);
            $table->foreign('dev_order_status_list_id')->references('id')->on('dev_order_status_list');

            $table->integer('qty')->unsignet()->nullable;

            $table->decimal('price_for_one_product');

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

        Schema::drop('dev_order_index_sub_product');
    }
}
