<?php

use Illuminate\Database\Seeder;

class SizeChartTableSeeder extends Seeder
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
        DB::table('dev_size_chart')->delete();

        /**
         * Inserting
         */
        DB::table('dev_size_chart')->insert(
            [
                [
                    'id' => 1,
                    'brand_id' => 1,
                    'category_id' => 11,
                    'size_id' => 4,
                    'brand_size'  => 46,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'brand_id' => 2,
                    'category_id' => 10,
                    'size_id' => 1,
                    'brand_size'  => 48,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'brand_id' => 2,
                    'category_id' => 10,
                    'size_id' => 2,
                    'brand_size'  => 50,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
