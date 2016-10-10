<?php

use Illuminate\Database\Seeder;

class ProductIndexPriceTableSeeder extends Seeder
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
        DB::table('dev_product_index_price')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_index_price')->insert(
            array(
                array(
                    'id' => 1,
                    'sub_product_id' => 1,
                    'index_price' => 10000,
                    'retail_price' => 9000,
                    'final_price' => 15000,
                    'special_price' => 5000,
                    'sale_percent' => 33,
                    'product_marga' => 5000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'sub_product_id' => 2,
                    'index_price' => 20000,
                    'retail_price' => 19000,
                    'final_price' => 30000,
                    'special_price' => 25000,
                    'sale_percent' => 18,
                    'product_marga' => 5000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'sub_product_id' => 3,
                    'index_price' => 50000,
                    'retail_price' => 45000,
                    'final_price' => 100000,
                    'special_price' => 40000,
                    'sale_percent' => 60,
                    'product_marga' => 10000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
