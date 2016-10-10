<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToDevProductIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dev_product_index', function(Blueprint $table){
            $table->foreign('stock_id')
                ->references('id')->on('dev_index_stock')
                ->onDelete('cascade');

            $table->foreign('dev_index_gender_id')
                ->references('id')->on('dev_index_gender')
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
        Schema::table('dev_product_index', function(Blueprint $table){
            $table->dropForeign(['stock_id']);
            $table->dropForeign(['dev_index_gender_id']);
        });
    }
}
