<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportPartiesCoincidenceLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_parties_coincidence_log', function(Blueprint $table){
            $table->increments('id');
            $table->integer('file_allocation_id')->unsigned();
            $table->integer('file_line')->unsigned();
            $table->integer('coincidence_status_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('file_allocation_id')->references('id')
                ->on('dev_import_parties_file_allocation');
            $table->foreign('coincidence_status_id')->references('id')
                ->on('dev_import_parties_coincidence_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_import_parties_coincidence_log', function(Blueprint $table){
            $table->dropForeign(['file_allocation_id']);
            $table->dropForeign(['coincidence_status_id']);
        });

        Schema::drop('dev_import_parties_coincidence_log');
    }
}
