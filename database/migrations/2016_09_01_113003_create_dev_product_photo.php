<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_photo', function(Blueprint $table){
            $table->increments('id');
            $table->text('photo');
            $table->integer('sub_product_id')->unsigned();
            $table->foreign('sub_product_id')->references('id')->on('dev_sub_product');
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
        Schema::drop('dev_product_photo');
    }
}
