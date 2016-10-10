<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportLogPartiesProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_log_parties_process', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('party_id')->unsigned();
            $table->integer('file_line')->unsigned();
            $table->integer('fat_status_id')->unsigned();
            $table->integer('sub_product_id')->nullable(); // WITHOUT ANY RELATION DUE TO NOT EXISTENCE
            $table->text('message');

            $table->foreign('party_id')->references('id')->on('dev_import_parties');
            $table->foreign('fat_status_id')->references('id')->on('dev_import_fat_status');
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
        Schema::table('dev_import_log_parties_process', function (Blueprint $table)
        {
            $table->dropForeign('dev_import_log_parties_process_party_id_foreign');
            $table->dropForeign('dev_import_log_parties_process_fat_status_id_foreign');
        });

        Schema::drop('dev_import_log_parties_process');
    }
}
