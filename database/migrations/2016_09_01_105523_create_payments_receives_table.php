<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_payments_receives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('paytype', 20);
            $table->string('order_id');
            $table->string('pay_system_order_id');
            $table->string('email');
            $table->string('phone');
            $table->string('ip');
            $table->decimal('amount');
            $table->decimal('commission');
            $table->char('currency', 3);
            $table->text('description');
            $table->string('type', 25);
            $table->integer('transaction_id');
            $table->dateTime('orderDateTime');
            $table->string('payment_status', 25);
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
        Schema::drop('dev_payments_receives');
    }
}
