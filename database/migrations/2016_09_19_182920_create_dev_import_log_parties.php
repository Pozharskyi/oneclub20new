<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportLogParties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_log_parties', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('party_id')->unsigned();
            $table->enum('modify_type', ['0', '1']);
            $table->integer('product_id')->unsigned();
            $table->integer('made_by')->unsigned();

            $table->foreign('party_id')->references('id')->on('dev_import_parties');
            $table->foreign('product_id')->references('id')->on('dev_product_index');
            $table->foreign('made_by')->references('id')->on('users');
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
        Schema::drop('dev_import_log_parties');
    }
}
