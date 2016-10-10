<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductDimensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_dimensions', function( Blueprint $table )
        {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->longText('product_colors'); // json for MySQL 5.7
            $table->longText('product_sizes'); // json for MySQL 5.7
            $table->longText('product_photos'); // json for MySQL 5.7
            $table->integer('product_total_quantity');
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
        Schema::drop('dev_product_dimensions');
    }
}
