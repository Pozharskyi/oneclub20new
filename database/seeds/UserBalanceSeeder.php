<?php

use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
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
        DB::table('dev_user_balance')->delete();

        /**
         * Inserting
         */
        DB::table('dev_user_balance')->insert(
            array(
                array(
                    'id' => 1,
                    'user_id' => 1,
                    'balance_amount' => 1000,
                    'balance_comment' => 'new comment',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'user_id' => 2,
                    'balance_amount' => 5000,
                    'balance_comment' => 'new comment',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'user_id' => 3,
                    'balance_amount' => 20000,
                    'balance_comment' => 'new comment',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
