<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevImportSalesShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_import_sales_share', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('sales_share_name')->unique();
            $table->text('first_header');
            $table->text('second_header');
            $table->timestamp('sales_share_start')->default('0000-00-00 00:00:00');
            $table->timestamp('sales_share_end')->default('0000-00-00 00:00:00');
            $table->integer('made_by')->unsigned();

            $table->foreign('made_by')->references('id')->on('users');

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
        Schema::table('dev_import_sales_share', function (Blueprint $table)
        {
            $table->dropForeign('dev_import_sales_share_made_by_foreign');
        });

        Schema::drop('dev_import_sales_share');
    }
}
