<?php

use Illuminate\Database\Seeder;

class ProductGenderTableSeeder extends Seeder
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
        DB::table('dev_product_gender')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_gender')->insert(
            [
                [
                    'id' => 1,
                    'dev_product_index_id' => 1,
                    'dev_index_gender_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'dev_product_index_id' => 2,
                    'dev_index_gender_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );

    }
}
