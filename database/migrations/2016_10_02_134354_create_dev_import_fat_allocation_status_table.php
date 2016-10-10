<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportFatAllocationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_fat_allocation_status', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('fat_status_id')->unsigned();
            $table->integer('fat_association_id')->unsigned();

            $table->foreign('fat_status_id')->references('id')->on('dev_import_fat_status');
            $table->foreign('fat_association_id')->references('id')->on('dev_import_fat_association_status');
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
        Schema::table('dev_import_fat_allocation_status', function (Blueprint $table)
        {
            $table->dropForeign('dev_import_fat_allocation_status_fat_status_id_foreign');
            $table->dropForeign('dev_import_fat_allocation_status_fat_association_id_foreign');
        });

        Schema::drop('dev_import_fat_allocation_status');
    }
}
