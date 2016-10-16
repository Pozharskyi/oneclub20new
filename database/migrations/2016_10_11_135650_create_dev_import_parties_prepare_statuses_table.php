<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportPartiesPrepareStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_parties_prepare_statuses', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('short_phrase');
            $table->string('file_column_name');

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
        Schema::drop('dev_import_parties_prepare_statuses');
    }
}
