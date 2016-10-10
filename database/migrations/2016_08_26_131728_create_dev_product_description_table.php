<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_description', function( Blueprint $table )
        {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->longText('product_name');
            $table->longText('supplier_product_name');
            $table->text('product_description');
            $table->text('product_composition');
            $table->text('comment_admin');
            $table->text('comment_frontend');
            $table->text('country_manufacturer');
            $table->integer('product_delivery_days');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('dev_product_index')
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
        Schema::drop('dev_product_description');
    }
}
