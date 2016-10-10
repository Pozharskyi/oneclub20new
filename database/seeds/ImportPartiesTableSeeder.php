<?php

use Illuminate\Database\Seeder;

class ImportPartiesTableSeeder extends Seeder
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
        DB::table('dev_import_parties')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties')->insert(
            array(
                array(
                    'id' => 1,
                    'party_name' => 'Levis Jeans',
                    'supplier_id' => 1,
                    'party_category_id' => 1,
                    'recommended_start' => '2016-09-19 01:01:01',
                    'recommended_end' => '2016-10-10 01:01:01',
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'party_name' => 'Channel Jeans',
                    'supplier_id' => 2,
                    'party_category_id' => 2,
                    'recommended_start' => '2016-09-19 01:01:01',
                    'recommended_end' => '2016-10-10 01:01:01',
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'party_name' => 'Morris Jeans',
                    'supplier_id' => 2,
                    'party_category_id' => 1,
                    'recommended_start' => '2016-09-19 01:01:01',
                    'recommended_end' => '2016-10-10 01:01:01',
                    'made_by' => 2,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
