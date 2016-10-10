<?php

use Illuminate\Database\Seeder;

class ImportSalesShareTableSeeder extends Seeder
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
        DB::table('dev_import_sales_share')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_sales_share')->insert(
            array(
                array(
                    'id' => 1,
                    'sales_share_name' => 'Распродажа джинсов Levis',
                    'sales_share_start' => '2016-09-09 01:01:01',
                    'sales_share_end' => '2016-10-09 01:01:01',
                    'first_header' => 'h1 Header',
                    'second_header' => 'h2 Header',
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'sales_share_name' => 'Распродажа джинсов Channel',
                    'sales_share_start' => '2016-09-09 01:01:01',
                    'sales_share_end' => '2016-10-09 01:01:01',
                    'first_header' => 'h1 Header',
                    'second_header' => 'h2 Header',
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'sales_share_name' => 'Распродажа джинсов Morris',
                    'sales_share_start' => '2016-09-09 01:01:01',
                    'sales_share_end' => '2016-10-09 01:01:01',
                    'first_header' => 'h1 Header',
                    'second_header' => 'h2 Header',
                    'made_by' => 2,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
