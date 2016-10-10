<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductIndexPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_index_price', function( Blueprint $table ){
            $table->increments('id');
            $table->integer('sub_product_id')->unsigned();
            $table->decimal('index_price'); // FROM SUPPLIER
            $table->decimal('retail_price'); // FROM SUB SHOP
            $table->decimal('final_price'); // SALE FIRST PRICE
            $table->decimal('special_price'); // SALE END PRICE
            $table->integer('sale_percent');
            $table->decimal('product_marga');
            $table->timestamps();

            $table->foreign('sub_product_id')
                ->references('id')->on('dev_sub_product')
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
        Schema::drop('dev_product_index_price');
    }
}












