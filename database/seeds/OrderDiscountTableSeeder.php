<?php

use Illuminate\Database\Seeder;

class OrderDiscountTableSeeder extends Seeder
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
        DB::table('dev_order_discount')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_discount')->insert(
            [
                [
                    'id' => 1,
                    'dev_index_discounts_id' => 2,
                    'dev_order_index_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]
        );
    }
}
