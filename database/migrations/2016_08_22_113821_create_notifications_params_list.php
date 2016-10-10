<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsParamsList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_notifications_params_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('template_name');
            $table->string('template_variable');
            $table->string('method_name');
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
        Schema::drop('dev_notifications_params_list');
    }
}
