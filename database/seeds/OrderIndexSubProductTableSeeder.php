<?php

use Illuminate\Database\Seeder;

class OrderIndexSubProductTableSeeder extends Seeder
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
        DB::table('dev_order_index_sub_product')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_index_sub_product')->insert(
            [
                [
                    'id' => 1,
                    'dev_sub_product_id' => 1,
                    'dev_order_index_id' => 1,
                    'dev_order_status_list_id' => 1,
                    'price_for_one_product' => 1000,
                    'qty' =>  1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'dev_sub_product_id' => 2,
                    'dev_order_index_id' => 1,
                    'dev_order_status_list_id' => 2,
                    'price_for_one_product' => 1000,
                    'qty'   =>  1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'dev_sub_product_id' => 1,
                    'dev_order_index_id' => 2,
                    'dev_order_status_list_id' => 1,
                    'price_for_one_product' => 1000,
                    'qty'   =>  1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]
        );
    }
}
