<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevIndexCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_index_categories', function( Blueprint $table){
            $table->increments('id');
            $table->string('category_name');
            $table->integer('made_by')->unsigned();
            $table->integer('parent_id')->default(0);
            $table->string('shortcut')->nullable();
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
        Schema::drop('dev_index_categories');
    }
}
