<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportSalesAssociationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_sales_association', function(Blueprint $table){
            $table->increments('id');
            $table->integer('import_index_sale_id')->unsigned();
            $table->integer('import_index_party_id')->unsigned();
            $table->integer('made_by')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('import_index_sale_id')->references('id')
                ->on('dev_import_index_sales');
            $table->foreign('import_index_party_id')->references('id')
                ->on('dev_import_index_parties');
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
        Schema::table('dev_import_sales_association', function(Blueprint $table){
            $table->dropForeign(['import_index_sale_id']);
            $table->dropForeign(['import_index_party_id']);
            $table->dropForeign(['made_by']);
        });

        Schema::drop('dev_import_sales_association');
    }
}
