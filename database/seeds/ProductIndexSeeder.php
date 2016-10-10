<?php

use Illuminate\Database\Seeder;

class ProductIndexSeeder extends Seeder
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
        DB::table('dev_product_index')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_index')->insert(
            array(
                array(
                    'id' => '1',
                    'sku' => 'FW16HM732793',
                    'product_store_id' => '1111-2222-3333-4444',
                    'product_backend_id' => '7777-7777-7777-7777',
                    'brand_id' => 1,
                    'category_id' => 8,
                    'stock_id' => 1,
                    'dev_index_gender_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'sku' => 'FW16HM73311',
                    'product_store_id' => '1491-9151-9515-9141',
                    'product_backend_id' => '9515-8519-5192-9510',
                    'brand_id' => 2,
                    'category_id' => 10,
                    'stock_id' => 2,
                    'dev_index_gender_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
