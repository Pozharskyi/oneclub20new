<?php

use Illuminate\Database\Seeder;

class ImportUpdateTableSeeder extends Seeder
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
        DB::table('dev_import_update')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_update')->insert(
            array(
                array(
                    'id' => 1,
                    'update_name' => 'Обновление акций Август 2016',
                    'recommended_start' => '2016-09-01 01:01:01',
                    'made_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'update_name' => 'Обновление остатков Август 2016',
                    'recommended_start' => '2016-09-01 01:01:01',
                    'made_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'update_name' => 'Обновление акций Июль 2016',
                    'recommended_start' => '2016-09-01 01:01:01',
                    'made_by' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
