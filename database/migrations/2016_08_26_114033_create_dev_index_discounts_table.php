<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevIndexDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_index_discounts', function( Blueprint $table )
        {
            $table->increments('id');
            $table->string('discount_id');
            $table->decimal('discount_amount',8,2)->unsigned();
            $table->dateTime('active_from');
            $table->dateTime('active_to');
            $table->enum('status', ['Активный', 'Не активный']);
            $table->text('comment');
            $table->string('rule');
            $table->enum('auto',['0','1']);
            $table->integer('min_basket_sum')->unsigned()->nullable();
            $table->integer('max_basket_sum')->unsigned()->nullable();
            $table->enum('type', ['percent', 'money']);
            $table->integer('subproduct_amount_from')->unsigned()->nullable();
            $table->integer('purchase_number')->nullable();
            $table->integer('coupon_rules_id')->unsigned()->nullable();
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
        Schema::drop('dev_index_discounts');
    }
}
