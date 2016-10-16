<?php

use Illuminate\Database\Seeder;

class ImportIndexPartiesTableSeeder extends Seeder
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
        DB::table('dev_import_index_parties')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_index_parties')->insert(
            [
                [
                    'id' => 1,
                    'import_supplier_id' => '1',
                    'party_name' => 'Джинсы Levis',
                    'party_start_date' => '2016-10-10',
                    'party_end_date' => '2016-21-10',
                    'party_days_count' => '11',
                    'made_by' => '1',
                    'buyer_id' => '2',
                    'support_id' => '1',
                    'import_index_categories_id' => '1',
                    'import_parties_status_id' => '6',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_supplier_id' => '2',
                    'party_name' => 'Футболки Dirk',
                    'party_start_date' => '2016-10-15',
                    'party_end_date' => '2016-10-20',
                    'party_days_count' => '5',
                    'made_by' => '2',
                    'buyer_id' => '1',
                    'support_id' => '2',
                    'import_index_categories_id' => '2',
                    'import_parties_status_id' => '6',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
