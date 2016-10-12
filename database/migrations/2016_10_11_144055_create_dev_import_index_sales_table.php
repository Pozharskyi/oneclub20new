<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportIndexSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_index_sales', function(Blueprint $table){
            $table->increments('id');
            $table->string('sale_name');
            $table->date('sale_start_date');
            $table->date('sale_end_date');
            $table->integer('sale_days_count');
            $table->integer('made_by')->unsigned();
            $table->integer('buyer_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('made_by')->references('id')
                ->on('users');
            $table->foreign('buyer_id')->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_import_index_sales', function(Blueprint $table){
            $table->dropForeign(['made_by']);
            $table->dropForeign(['buyer_id']);
        });

        Schema::drop('dev_import_index_sales');
    }
}
