<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_user_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('action_id')->unsigned();
            $table->string('field_changed')->nullable();
            $table->integer('fromto_id')->unsigned()->nullable();
            $table->string('fromto_type')->nullable();
            $table->dateTime('date');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('action_id')->references('id')->on('dev_user_log_action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dev_user_log');
    }
}
