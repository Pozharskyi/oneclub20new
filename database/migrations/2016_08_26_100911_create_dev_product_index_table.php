<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_index', function( Blueprint $table ){
            $table->increments('id');
            $table->string('sku')->unique();
            $table->string('product_store_id')->unique();
            $table->string('product_backend_id')->unique();
            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->integer('stock_id')->unsigned();
            $table->integer('dev_index_gender_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')
                ->references('id')->on('dev_product_brands')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')->on('dev_index_categories')
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
        Schema::drop('dev_product_index');
    }
}
