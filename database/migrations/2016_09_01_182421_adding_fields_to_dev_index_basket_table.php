<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingFieldsToDevIndexBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dev_index_basket', function (Blueprint $table){
            $table->integer('sub_product_id')->unsigned();
            $table->foreign('sub_product_id')
                ->references('id')->on('dev_sub_product')
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
        Schema::table('dev_index_basket', function (Blueprint $table){
            $table->dropForeign('dev_index_basket_sub_product_id_foreign');
            $table->dropColumn('sub_product_id');
        });
    }
}
