<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportSalesLogEditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_sales_log_edit', function(Blueprint $table){
            $table->increments('id');
            $table->integer('import_index_sale_id')->unsigned();
            $table->string('field_changed');
            $table->string('field_current_value');
            $table->string('field_changed_value');
            $table->integer('made_by')->unsigned();

            $table->timestamps();

            $table->foreign('import_index_sale_id')->references('id')
                ->on('dev_import_index_sales');
            $table->foreign('made_by')->references('id')
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
        Schema::table('dev_import_sales_log_edit', function(Blueprint $table){
            $table->dropForeign(['import_index_sale_id']);
            $table->dropForeign(['made_by']);
        });

        Schema::drop('dev_import_parties_log_edit');
    }
}
