<?php

use Illuminate\Database\Seeder;

class OrderBonusesTabelSeeder extends Seeder
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
        DB::table('dev_order_index_bonus')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_index_bonus')->insert(
            [
                [
                    'id' => 1,
                    'bonus_count' => 100,
                    'dev_order_index_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]
        );
    }
}
