<?php

use Illuminate\Database\Seeder;

class ImportPartiesPrepareLogTableSeeder extends Seeder
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
        DB::table('dev_import_parties_prepare_log')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_prepare_log')->insert(
            [
                [
                    'id' => 1,
                    'file_allocation_id' => '1',
                    'file_line' => '1',
                    'prepare_status_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'file_allocation_id' => '1',
                    'file_line' => '2',
                    'prepare_status_id' => '2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'file_allocation_id' => '2',
                    'file_line' => '1',
                    'prepare_status_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
