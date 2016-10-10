<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingForeignKeysToDevOrderIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dev_order_index', function(Blueprint $table){
            $table->foreign('payment_type_id')->references('id')->on('dev_payment_types');
            $table->foreign('discount_id')->references('id')->on('dev_index_discounts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_order_index', function(Blueprint $table){
            $table->dropForeign(['payment_type_id']);
            $table->dropForeign(['discount_id']);
        });
    }
}
