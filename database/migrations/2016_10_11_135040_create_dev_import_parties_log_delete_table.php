<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportPartiesLogDeleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_parties_log_delete', function(Blueprint $table){
            $table->increments('id');
            $table->integer('import_index_party_id')->unsigned();
            $table->string('comment')->nullable();
            $table->enum('is_approved', ['Подтвержден', 'Не подтвержден'])->default('Не подтвержден');
            $table->integer('made_by')->unsigned();

            $table->timestamps();

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
        Schema::table('dev_import_parties_log_delete', function(Blueprint $table){
            $table->dropForeign(['import_index_party_id']);
            $table->dropForeign(['made_by']);
        });

        Schema::drop('dev_import_parties_log_delete');
    }
}
