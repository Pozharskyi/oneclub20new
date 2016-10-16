<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportPartiesPhotosFoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_parties_photos_founds', function(Blueprint $table){
            $table->increments('id');
            $table->integer('file_allocation_id')->unsigned();
            $table->integer('file_line')->unsigned();
            $table->string('photo_uri');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('file_allocation_id')->references('id')
                ->on('dev_import_parties_file_allocation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_import_parties_photos_founds');
    }
}
