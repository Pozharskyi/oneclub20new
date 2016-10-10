<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('shop');
            $table->text('brands');
            $table->string('contact_person');
            $table->string('phones');
            $table->string('email');
            $table->string('coefficient');
            $table->string('product_marga')->nullable();
            $table->string('time_of_returns');
            $table->enum('work_status', ['Работаем', 'Не работаем'])->default('Не работаем');
            $table->text('work_comment')->nullable();
            $table->enum('agreement', ['Есть', 'Нету']);
            $table->date('start_working');
            $table->string('payment_form');
            $table->string('payment_postpone')->nullable();
            $table->string('ecommerce_comment');
            $table->string('address_sending');
            $table->string('logistic_comment')->nullable();
            $table->string('address_return')->nullable();
            $table->text('products_category');
            $table->integer('buyer_id')->unsigned();
            $table->integer('made_by')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('buyer_id')->references('id')->on('users');
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
        Schema::drop('dev_supplier');
    }
}
