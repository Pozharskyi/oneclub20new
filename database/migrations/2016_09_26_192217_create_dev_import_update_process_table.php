<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportUpdateProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_update_process', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('update_id')->unsigned();
            $table->integer('in_process_atm')->unsigned();
            $table->integer('in_process_total')->unsigned();
            $table->text('file_base_path');
            $table->enum('fat_status', ['В процессе', 'Готово'])->default('В процессе');

            $table->foreign('update_id')->references('id')->on('dev_import_update');

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
        Schema::table('dev_import_update_process', function (Blueprint $table)
        {
            $table->dropForeign('dev_import_update_process_update_id_foreign');
        });

        Schema::drop('dev_import_update_process');
    }
}
