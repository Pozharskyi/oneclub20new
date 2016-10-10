<?php

use Illuminate\Database\Seeder;

class UsersSubscribationsSeeder extends Seeder
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
        DB::table('dev_users_subscribations')->delete();
        /**
         * Inserting
         */
        DB::table('dev_users_subscribations')->insert(
            [
                [
                    'id'    =>  '1',
                    'user_id'   =>  '1',
                    'subscribation_id'  =>  '1'
                ],
                [
                    'id'    =>  '2',
                    'user_id'   =>  '1',
                    'subscribation_id'  =>  '3'
                ],
                [
                    'id'    =>  '3',
                    'user_id'   =>  '1',
                    'subscribation_id'  =>  '4'
                ],
                [
                    'id'    =>  '4',
                    'user_id'   =>  '1',
                    'subscribation_id'  =>  '6'
                ],
                [
                    'id'    =>  '5',
                    'user_id'   =>  '1',
                    'subscribation_id'  =>  '7'
                ],
                [
                    'id'    =>  '6',
                    'user_id'   =>  '1',
                    'subscribation_id'  =>  '8'
                ],
                [
                    'id'    =>  '7',
                    'user_id'   =>  '2',
                    'subscribation_id'  =>  '2'
                ],
                [
                    'id'    =>  '8',
                    'user_id'   =>  '2',
                    'subscribation_id'  =>  '5'
                ],
                [
                    'id'    =>  '9',
                    'user_id'   =>  '2',
                    'subscribation_id'  =>  '7'
                ],
                [
                    'id'    =>  '10',
                    'user_id'   =>  '2',
                    'subscribation_id'  =>  '8'
                ]
            ]
        );
    }
}
