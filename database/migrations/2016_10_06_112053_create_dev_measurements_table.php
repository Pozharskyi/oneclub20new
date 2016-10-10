<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_measurements', function(Blueprint $table){
            $table->increments('id');
            $table->integer('size_chart_id')->unsigned();
            $table->integer('measurements_names_id')->unsigned();
            $table->string('value');

            $table->foreign('size_chart_id')->references('id')->on('dev_size_chart');
            $table->foreign('measurements_names_id')->references('id')->on('dev_measurements_names');

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
        Schema::drop('dev_measurements');
    }
}
