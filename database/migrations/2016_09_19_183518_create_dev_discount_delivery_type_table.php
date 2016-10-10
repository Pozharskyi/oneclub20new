<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevDiscountDeliveryTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_discount_delivery_type', function(Blueprint $table){
            $table->increments('id');
            $table->integer('discount_id')->unsigned();
            $table->integer('delivery_type_id')->unsigned();

            $table->foreign('discount_id')->references('id')->on('dev_index_discounts');
            $table->foreign('delivery_type_id')->references('id')->on('dev_delivery_types');

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
        Schema::drop('dev_discount_delivery_type');
    }
}
