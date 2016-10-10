<?php

use Illuminate\Database\Seeder;

class SubscribationsSeeder extends Seeder
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
        DB::table('dev_subscribations')->delete();
        /**
         * Inserting
         */
        DB::table('dev_subscribations')->insert(
            [
                [
                    'id'    =>  '1',
                    'name'  =>  'Товары для женщин',
                    'type'  =>  '1'
                ],
                [
                    'id'    =>  '2',
                    'name'  =>  'Товары для мужчин',
                    'type'  =>  '1'
                ],
                [
                    'id'    =>  '3',
                    'name'  =>  'Товары для детей',
                    'type'  =>  '1'
                ],
                [
                    'id'    =>  '4',
                    'name'  =>  'Товары для женщин',
                    'type'  =>  '2'
                ],
                [
                    'id'    =>  '5',
                    'name'  =>  'Товары для мужчин',
                    'type'  =>  '2'
                ],
                [
                    'id'    =>  '6',
                    'name'  =>  'Товары для детей',
                    'type'  =>  '2'
                ],
                [
                    'id'    =>  '7',
                    'name'  =>  'Товары для дома',
                    'type'  =>  '2'
                ],
                [
                    'id'    =>  '8',
                    'name'  =>  'Товары для дома',
                    'type'  =>  '1'
                ]
            ]
        );
    }
}
