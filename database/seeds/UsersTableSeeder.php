<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Deleting All previous records
         */
        DB::table('users')->delete();

        /**
         * Inserting
         */
        DB::table('users')->insert(
            array(
                array(
                    'id' => 1,
                    'name' => 'Oleksandr Serdiuk',
                    'email' => 'serdiuk.oleksandr@gmail.com',
                    'password' => bcrypt( 'test' ),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'provider' => NULL,
                    'social_id' => NULL,
                    'f_name' => 'Oleksandr',
                    'l_name' => 'Serdiuk',
                    'phone' => NULL,
                    'gender' => 'Male',
                    'date_of_birth' => '1997-04-01',
                    'person_category_self_update' => '0',
                ),
                array(
                    'id' => 2,
                    'name' => 'Dmitry Medvedev',
                    'email' => 'medvedev@gmail.com',
                    'password' => bcrypt( 'test123' ),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'provider' => NULL,
                    'social_id' => NULL,
                    'f_name' => 'Dmitry',
                    'l_name' => 'Medvedev',
                    'phone' => NULL,
                    'gender' => 'Male',
                    'date_of_birth' => '1992-04-01',
                    'person_category_self_update' => '0',
                ),
                array(
                    'id' => 3,
                    'name' => 'Dmitry Wolf',
                    'email' => 'wolf@gmail.com',
                    'password' => bcrypt( 'qweasd' ),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'provider' => NULL,
                    'social_id' => NULL,
                    'f_name' => 'Dmitry',
                    'l_name' => 'Wolf',
                    'phone' => NULL,
                    'gender' => 'Male',
                    'date_of_birth' => '1982-03-31',
                    'person_category_self_update' => '0',
                ),
            )
        );
    }
}
