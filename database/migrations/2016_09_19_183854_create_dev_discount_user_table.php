<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevDiscountUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_discount_user', function(Blueprint $table){
            $table->increments('id');
            $table->integer('discount_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('discount_id')->references('id')->on('dev_index_discounts');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('dev_discount_user');
    }
}
