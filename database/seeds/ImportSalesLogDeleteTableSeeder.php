<?php

use Illuminate\Database\Seeder;

class ImportSalesLogDeleteTableSeeder extends Seeder
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
        DB::table('dev_import_sales_log_delete')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_sales_log_delete')->insert(
            [
                [
                    'id' => 1,
                    'import_index_sale_id' => '1',
                    'comment' => 'Не удачная товарная акция',
                    'is_approved' => 'Не подтвержден',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_index_sale_id' => '2',
                    'comment' => 'Название не соответсвует акции',
                    'is_approved' => 'Не подтвержден',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
