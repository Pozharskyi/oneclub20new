<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsPopularityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_popularity', function(Blueprint $table){
            $table->increments('id');
            $table->integer('sub_product_id')->unsigned();
            $table->integer('popularity')->unsigned();
            $table->timestamps();

            $table->foreign('sub_product_id')
                ->references('id')
                ->on('dev_sub_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_product_popularity');
    }
}
