<?php

use Illuminate\Database\Seeder;

class ImportPartiesFileAllocationTableSeeder extends Seeder
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
        DB::table('dev_import_parties_file_allocation')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_file_allocation')->insert(
            [
                [
                    'id' => 1,
                    'import_index_party_id' => '1',
                    'import_file_path' => '/uploads/2016_08_03V194104.csv',
                    'file_lines_processed' => '2',
                    'file_lines_total' => '2',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_index_party_id' => '2',
                    'import_file_path' => '/uploads/2016_09_10V203307.csv',
                    'file_lines_processed' => '1',
                    'file_lines_total' => '1',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
