<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportPartiesFileAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_parties_file_allocation', function(Blueprint $table){
            $table->increments('id');
            $table->integer('import_index_party_id')->unsigned();
            $table->string('import_file_path');
            $table->integer('file_lines_processed')->unsigned();
            $table->integer('file_lines_total')->unsiged();
            $table->integer('made_by')->unsigned();
            $table->enum('allocation_status', [
                'Найдены ошибки', 'Файл не корректный',
                'Готово к обработке', 'Файл обработан',
            ]);

            $table->timestamps();
            $table->softDeletes();

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
        Schema::table('dev_import_parties_file_allocation', function(Blueprint $table){
            $table->dropForeign(['import_index_party_id']);
            $table->dropForeign(['made_by']);
        });

        Schema::drop('dev_import_parties_file_allocation');
    }
}
