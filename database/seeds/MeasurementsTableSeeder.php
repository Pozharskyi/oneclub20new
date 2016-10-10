<?php

use Illuminate\Database\Seeder;

class MeasurementsTableSeeder extends Seeder
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
        DB::table('dev_measurements')->delete();

        /**
         * Inserting
         */
        DB::table('dev_measurements')->insert(
            [
                [
                    'id' => 1,
                    'size_chart_id' => 1,
                    'measurements_names_id' => 1,
                    'value' => '79-82',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'size_chart_id' => 1,
                    'measurements_names_id' => 2,
                    'value' => '91-94',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'size_chart_id' => 1,
                    'measurements_names_id' => 3,
                    'value' => '89-91',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'size_chart_id' => 2,
                    'measurements_names_id' => 1,
                    'value' => '83-86',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'size_chart_id' => 2,
                    'measurements_names_id' => 2,
                    'value' => '96-99',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'size_chart_id' => 2,
                    'measurements_names_id' => 3,
                    'value' => '92-95',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
