<?php

use Illuminate\Database\Seeder;

class ImportLogUpdateProcessTableSeeder extends Seeder
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
        DB::table('dev_import_log_update_process')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_log_update_process')->insert(
            array(
                array(
                    'id' => 1,
                    'update_id' => 1,
                    'file_line' => 0,
                    'fat_status_id' => 10,
                    'sub_product_id' => 1,
                    'message' => 'any',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'update_id' => 1,
                    'file_line' => 1,
                    'fat_status_id' => 11,
                    'sub_product_id' => 2,
                    'message' => 'any',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'update_id' => 1,
                    'file_line' => 2,
                    'fat_status_id' => 10,
                    'sub_product_id' => 3,
                    'message' => 'any',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )

        );
    }
}
