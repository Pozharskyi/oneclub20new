<?php

use Illuminate\Database\Seeder;

class ProductPopularityTableSeeder extends Seeder
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
        DB::table('dev_product_popularity')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_popularity')->insert(
            [
                [
                    'id' => 1,
                    'sub_product_id' => 1,
                    'popularity' => 50,
                ],
                [
                    'id' => 2,
                    'sub_product_id' => 2,
                    'popularity' => 81,
                ],
                [
                    'id' => 3,
                    'sub_product_id' => 3,
                    'popularity' => 75,
                ],
            ]
        );
    }
}
