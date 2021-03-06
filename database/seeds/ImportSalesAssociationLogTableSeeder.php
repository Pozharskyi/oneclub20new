<?php

use Illuminate\Database\Seeder;

class ImportSalesAssociationLogTableSeeder extends Seeder
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
        DB::table('dev_import_sales_association_log')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_sales_association_log')->insert(
            [
                [
                    'id' => 1,
                    'import_index_sale_id' => '1',
                    'import_index_party_id' => '1',
                    'status' => 'Добавлено',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_index_sale_id' => '2',
                    'import_index_party_id' => '1',
                    'status' => 'Убрано',
                    'made_by' => '2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'import_index_sale_id' => '1',
                    'import_index_party_id' => '2',
                    'status' => 'Добавлено',
                    'made_by' => '2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
