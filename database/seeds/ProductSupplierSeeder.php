<?php

use Illuminate\Database\Seeder;

class ProductSupplierSeeder extends Seeder
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
        DB::table('dev_product_supplier')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_supplier')->insert(
            [
                [
                    'id' => 1,
                    'sub_product_id' => 1,
                    'supplier_id'    =>  1,
                    'qty'   =>  5,
                    'purhace_price' =>  '300',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'sub_product_id' => 2,
                    'supplier_id'    =>  1,
                    'qty'   =>  5,
                    'purhace_price' =>  '300',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'sub_product_id' => 2,
                    'supplier_id'    =>  2,
                    'qty'   =>  25,
                    'purhace_price' =>  '350',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'sub_product_id' => 3,
                    'supplier_id'    =>  2,
                    'qty'   =>  8,
                    'purhace_price' =>  '200',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]
        );
    }
}
