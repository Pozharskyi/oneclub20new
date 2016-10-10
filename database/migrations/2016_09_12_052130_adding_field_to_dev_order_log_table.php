<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingFieldToDevOrderLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dev_order_log', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();

            $table->foreign('order_id')->references('id')->on('dev_order_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dev_order_log', function (Blueprint $table) {
            $table->dropForeign('dev_order_log_order_id_foreign');
            $table->dropColumn('order_id');
        });
    }
}
