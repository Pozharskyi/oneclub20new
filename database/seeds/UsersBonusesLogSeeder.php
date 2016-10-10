<?php

use Illuminate\Database\Seeder;

class UsersBonusesLogSeeder extends Seeder
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
        DB::table('dev_users_bonuses_log')->delete();

        /**
         * Inserting
         */
        DB::table('dev_users_bonuses_log')->insert(
            array(
                array(
                    'id' => 1,
                    'user_id'   => 1,
                    'bonus_type_id' =>  1,
                    'amount'    =>  '1000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'user_id'   => 2,
                    'bonus_type_id' =>  1,
                    'amount'    =>  '1000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'user_id'   => 3,
                    'bonus_type_id' =>  1,
                    'amount'    =>  '1000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 4,
                    'user_id'   => 2,
                    'bonus_type_id' =>  3,
                    'amount'    =>  '4000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                )
            ,
                array(
                    'id' => 5,
                    'user_id'   => 3,
                    'bonus_type_id' =>  3,
                    'amount'    =>  '19000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                )
            )
        );
    }
}
