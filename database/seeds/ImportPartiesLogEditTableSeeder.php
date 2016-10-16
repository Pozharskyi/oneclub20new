<?php

use Illuminate\Database\Seeder;

class ImportPartiesLogEditTableSeeder extends Seeder
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
        DB::table('dev_import_parties_log_edit')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_log_edit')->insert(
            [
                [
                    'id' => 1,
                    'import_index_party_id' => '1',
                    'field_changed' => 'party_name',
                    'field_current_value' => 'Джинсы Levis',
                    'field_changed_value' => 'Джинсы крутых Levis',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_index_party_id' => '2',
                    'field_changed' => 'party_start_date',
                    'field_current_value' => '2016-10-15 00:00:01',
                    'field_changed_value' => '2016-09-01 01:01:01',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
