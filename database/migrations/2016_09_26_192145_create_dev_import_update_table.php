<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_update', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('update_name');
            $table->timestamp('recommended_start')->default('0000-00-00 00:00:00');
            $table->integer('made_by')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('made_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_import_update', function (Blueprint $table)
        {
            $table->dropForeign('dev_import_update_made_by_foreign');
        });

        Schema::drop('dev_import_update');
    }
}
