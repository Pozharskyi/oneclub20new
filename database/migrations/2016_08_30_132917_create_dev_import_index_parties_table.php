<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportIndexPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_index_parties', function(Blueprint $table){
            $table->increments('id');
            $table->integer('import_supplier_id')->unsigned();
            $table->string('party_name');
            $table->timestamp('party_start_date');
            $table->timestamp('party_end_date');
            $table->integer('party_days_count');
            $table->integer('made_by')->unsigned();
            $table->integer('buyer_id')->unsigned();
            $table->integer('support_id')->unsigned();
            $table->integer('import_index_categories_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('import_supplier_id')->references('id')
                ->on('dev_import_index_suppliers');
            $table->foreign('made_by')->references('id')
                ->on('users');
            $table->foreign('buyer_id')->references('id')
                ->on('users');
            $table->foreign('support_id')->references('id')
                ->on('users');
            $table->foreign('import_index_categories_id')->references('id')
                ->on('dev_import_index_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_import_index_parties', function(Blueprint $table){
            $table->dropForeign(['import_supplier_id']);
            $table->dropForeign(['made_by']);
            $table->dropForeign(['buyer_id']);
            $table->dropForeign(['support_id']);
            $table->dropForeign(['import_index_categories_id']);
        });

        Schema::drop('dev_import_index_parties');
    }
}
