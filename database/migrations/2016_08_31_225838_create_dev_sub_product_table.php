<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevSubProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_sub_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode')->unique();
            $table->integer('dev_product_index_id')->unsigned();
            $table->foreign('dev_product_index_id')->references('id')->on('dev_product_index');

            $table->integer('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('dev_import_index_suppliers');

            $table->decimal('markup_price');

            $table->integer('quantity')->unsigned();
            $table->integer('delivery_days')->unsigned();

            $table->integer('dev_product_size_id')->unsigned();
            $table->foreign('dev_product_size_id')->references('id')->on('dev_product_size');

            $table->enum('is_approved', ['0', '1'])->default('0');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_sub_product');
    }
}
