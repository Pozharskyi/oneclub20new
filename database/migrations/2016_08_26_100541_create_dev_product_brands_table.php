<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_brands', function( Blueprint $table ){
            $table->increments('id');
            $table->string('brand_name');
            $table->integer('made_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('made_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_product_brands');
    }
}
