<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportSalesAssociation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_sales_association', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('party_id')->unsigned();
            $table->integer('share_id')->unsigned();
            $table->integer('made_by')->unsigned();

            $table->foreign('made_by')->references('id')->on('users');
            $table->foreign('party_id')->references('id')->on('dev_import_parties');
            $table->foreign('share_id')->references('id')->on('dev_import_sales_share');

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
        Schema::table('dev_import_sales_association', function (Blueprint $table)
        {
            $table->dropForeign('dev_import_sales_association_made_by_foreign');
            $table->dropForeign('dev_import_sales_association_party_id_foreign');
            $table->dropForeign('dev_import_sales_association_share_id_foreign');
        });

        Schema::drop('dev_import_sales_association');
    }
}
