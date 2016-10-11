<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportSalesAssociationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_sales_association_log', function(Blueprint $table){
            $table->increments('id');
            $table->integer('import_index_sale_id')->unsigned();
            $table->integer('import_index_party_id')->unsigned();
            $table->enum('status', ['Добавлено', 'Убрано']);
            $table->integer('made_by')->unsigned();

            $table->timestamps();

            $table->foreign('import_index_sale_id')->references('id')
                ->on('dev_import_index_sales');
            $table->foreign('import_index_party_id')->references('id')
                ->on('dev_import_index_parties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_import_sales_association_log', function(Blueprint $table){
            $table->dropForeign(['import_index_sale_id']);
            $table->dropForeign(['import_index_party_id']);
        });

        Schema::drop('dev_import_sales_association_log');
    }
}
