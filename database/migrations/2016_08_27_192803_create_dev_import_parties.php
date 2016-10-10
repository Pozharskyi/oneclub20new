<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportParties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_parties', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('party_name');
            $table->integer('supplier_id')->unsigned();
            $table->integer('party_category_id')->unsigned();
            $table->timestamp('recommended_start')->default('0000-00-00 00:00:00');
            $table->timestamp('recommended_end')->default('0000-00-00 00:00:00');
            $table->integer('made_by')->unsigned();

            $table->foreign('supplier_id')->references('id')->on('dev_supplier');
            $table->foreign('party_category_id')->references('id')->on('dev_import_parties_categories');
            $table->foreign('made_by')->references('id')->on('users');
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
        Schema::drop('dev_import_parties');
    }
}
