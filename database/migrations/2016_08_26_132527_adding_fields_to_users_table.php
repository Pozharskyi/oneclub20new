<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function( Blueprint $table )
        {
            $table->enum('provider', ['google', 'facebook'])->nullable();
            $table->string('social_id')->nullable();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('phone')->unique()->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();

            $table->enum('person_category_self_update', ['0', '1'])->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('f_name');
            $table->dropColumn('l_name');
            $table->dropColumn('phone');
            $table->dropColumn('gender');
            $table->dropColumn('date_of_birth');

            $table->dropColumn('person_category_self_update');
        });
    }
}
