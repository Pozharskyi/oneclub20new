<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingForeignToDevIndexDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dev_index_discounts', function(Blueprint $table){
            $table->foreign('coupon_rules_id')->references('id')->on('dev_coupon_rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_index_discounts', function(Blueprint $table){
            $table->dropForeign(['coupon_rules_id']);
        });
    }
}
