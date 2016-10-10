<?php

use Illuminate\Database\Seeder;

class ImportLogPartiesProcessTableSeeder extends Seeder
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
        DB::table('dev_import_log_parties_process')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_log_parties_process')->insert(
            array(
                array(
                    'id' => 1,
                    'party_id' => 1,
                    'file_line' => 1,
                    'fat_status_id' => 1,
                    'message' => '',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'party_id' => 1,
                    'file_line' => 2,
                    'fat_status_id' => 2,
                    'message' => '',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'party_id' => 1,
                    'file_line' => 3,
                    'fat_status_id' => 3,
                    'message' => '',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )

        );
    }
}
