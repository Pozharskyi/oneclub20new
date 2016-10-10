<?php

use Illuminate\Database\Seeder;

class SubProductTableSeeder extends Seeder
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
        DB::table('dev_sub_product')->delete();

        /**
         * Inserting
         */
        DB::table('dev_sub_product')->insert(
            [
                [
                    'id' => 1,
                    'barcode' => '1234-5678-8765-4321',
                    'dev_product_index_id' => 1,
                    'dev_import_parties_id' => 1,
                    'supplier_id' => 1,
                    'markup_price'  =>  '0',
                    'quantity' => 20,
                    'dev_product_color_id' => 1,
                    'dev_product_size_id' => 1,
                    'is_approved' => '1',
                    'delivery_days' =>1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'barcode' => '1353-1576-5765-1124',
                    'dev_product_index_id' => 1,
                    'dev_import_parties_id' => 2,
                    'supplier_id' => 1,
                    'markup_price'  =>  '100',
                    'quantity' => 14,
                    'dev_product_color_id' => 1,
                    'dev_product_size_id' => 2,
                    'is_approved' => '1',
                    'delivery_days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'barcode' => '1353-1576-5765-9524',
                    'dev_product_index_id' => 2,
                    'dev_import_parties_id' => 3,
                    'supplier_id' => 1,
                    'markup_price'  =>  '0',
                    'quantity' => 10,
                    'dev_product_color_id' => 2,
                    'dev_product_size_id' => 2,
                    'is_approved' => '1',
                    'delivery_days' => 3,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]
        );
    }
}
