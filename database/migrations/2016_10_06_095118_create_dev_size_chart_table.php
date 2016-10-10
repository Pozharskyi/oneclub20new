<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevSizeChartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_size_chart', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('size_id')->unsigned();

            $table->integer('brand_size');

            $table->foreign('brand_id')->references('id')->on('dev_product_brands');
            $table->foreign('category_id')->references('id')->on('dev_index_categories');
            $table->foreign('size_id')->references('id')->on('dev_product_size');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_size_chart');
    }
}
