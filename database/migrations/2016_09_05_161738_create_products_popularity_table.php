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
            $table->integer('dev_product_index_id')->unsigned();
            $table->integer('popularity')->unsigned();
            $table->timestamps();

            $table->foreign('dev_index_product_id')
                ->references('id')
                ->on('dev_product_index');
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
