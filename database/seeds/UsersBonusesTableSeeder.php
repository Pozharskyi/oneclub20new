<?php

use Illuminate\Database\Seeder;

class UsersBonusesTableSeeder extends Seeder
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
        DB::table('dev_users_bonuses')->delete();

        /**
         * Inserting
         */
        DB::table('dev_users_bonuses')->insert(
            array(
                array(
                    'id' => 1,
                    'user_id' => 1,
                    'bonuses_amount' => 900,
                    'bonuses_comment' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'user_id' => 2,
                    'bonuses_amount' => 5000,
                    'bonuses_comment' => 'Бонус за регистрацию',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'user_id' => 3,
                    'bonuses_amount' => 20000,
                    'bonuses_comment' => 'Бонус за регистрацию',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
