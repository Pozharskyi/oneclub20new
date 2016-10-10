<?php

use Illuminate\Database\Seeder;

class ImportUpdateProcessTableSeeder extends Seeder
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
        DB::table('dev_import_update_process')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_update_process')->insert(
            array(
                array(
                    'id' => 1,
                    'update_id' => 1,
                    'in_process_atm' => 100,
                    'in_process_total' => 100,
                    'file_base_path' => '/first_path/test/exception.csv',
                    'fat_status' => 'Готово',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'update_id' => 2,
                    'in_process_atm' => 100,
                    'in_process_total' => 100,
                    'file_base_path' => '/new/exception/again.csv',
                    'fat_status' => 'Готово',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'update_id' => 3,
                    'in_process_atm' => 100,
                    'in_process_total' => 100,
                    'file_base_path' => '/exception/test/new.csv',
                    'fat_status' => 'Готово',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
