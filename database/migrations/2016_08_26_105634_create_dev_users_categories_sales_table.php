<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevUsersCategoriesSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_users_categories_sales', function( Blueprint $table ){
            $table->increments('id');
            $table->integer('person_category_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->decimal('discount');
            $table->decimal('product_category')->nullable();
            $table->decimal('product_min_price')->nullable();
            $table->decimal('product_max_price')->nullable();
            $table->decimal('product_marga')->nullable();
            $table->timestamps();

            $table->foreign('person_category_id')
                ->references('id')->on('dev_users_categories')
                ->onDelete('cascade');

            $table->foreign('brand_id')
                ->references('id')->on('dev_product_brands')
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
        Schema::drop('dev_users_categories_sales');
    }
}
