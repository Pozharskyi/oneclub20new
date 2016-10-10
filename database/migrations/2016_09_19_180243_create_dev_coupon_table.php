<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_coupon', function(Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_code');
            $table->integer('coupon_rules_id')->unsigned();

            $table->foreign('coupon_rules_id')->references('id')->on('dev_coupon_rules');
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
        Schema::drop('dev_coupon');
    }
}
