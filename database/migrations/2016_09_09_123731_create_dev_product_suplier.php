<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevProductSuplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_product_supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_product_id')->unsignet();
            $table->integer('supplier_id')->unsignet();
            $table->decimal('qty');
            $table->decimal('purhace_price'); // RIGHT COPY PASTE
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
        Schema::drop('dev_product_supplier');
    }
}
