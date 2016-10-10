<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_notifications_index', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_id')->unsigned();
            $table->integer('notification_type_id')->unsigned();
            $table->string('notification_request_message');
            $table->string('notification_params');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('notification_id')
                ->references('id')->on('dev_notifications_list')
                ->onDelete('cascade');
            $table->foreign('notification_type_id')
                ->references('id')->on('dev_notifications_types_list')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_notifications_index');
    }
}
