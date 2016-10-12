<?php

use Illuminate\Database\Seeder;

class ImportIndexSalesTableSeeder extends Seeder
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
        DB::table('dev_import_index_sales')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_index_sales')->insert(
            [
                [
                    'id' => 1,
                    'sale_name' => 'Распродажа джинс Levis',
                    'sale_start_date' => '2016-10-15',
                    'sale_end_date' => '2016-10-21',
                    'sale_days_count' => '6',
                    'made_by' => '1',
                    'buyer_id' => '2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'sale_name' => 'Распродажа курток Dirk',
                    'sale_start_date' => '2016-10-12',
                    'sale_end_date' => '2016-10-17',
                    'sale_days_count' => '5',
                    'made_by' => '2',
                    'buyer_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
