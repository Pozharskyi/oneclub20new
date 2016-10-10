<?php

use Illuminate\Database\Seeder;

class SubscribationsTypeSeeder extends Seeder
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
        DB::table('dev_subscribations_type')->delete();
        /**
         * Inserting
         */
        DB::table('dev_subscribations_type')->insert(
            [
                [
                    'id'    =>  '1',
                    'name'   =>  'Ежедненвые'
                ],
                [
                    'id'    =>  '2',
                    'name'   =>  'Еженедельные'
                ],
                [
                    'id'    =>  '3',
                    'name'   =>  'Специальные'
                ]
            ]
        );
    }
}
