<?php

use Illuminate\Database\Seeder;

class ImportSalesLogEditTableSeeder extends Seeder
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
        DB::table('dev_import_sales_log_edit')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_sales_log_edit')->insert(
            [
                [
                    'id' => 1,
                    'import_index_sale_id' => '1',
                    'field_changed' => 'sale_name',
                    'field_current_value' => 'Распродажа джинс Levis + Dirk',
                    'field_changed_value' => 'Распродажа Levis',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_index_sale_id' => '1',
                    'field_changed' => 'sale_name',
                    'field_current_value' => 'Распродажа джинс Levis',
                    'field_changed_value' => 'Распродажа джинс Levis + Dirk',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
