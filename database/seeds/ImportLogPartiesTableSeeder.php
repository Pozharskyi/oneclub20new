<?php

use Illuminate\Database\Seeder;

class ImportLogPartiesTableSeeder extends Seeder
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
        DB::table('dev_import_log_parties')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_log_parties')->insert(
            array(
                array(
                    'id' => 1,
                    'party_id' => 1,
                    'modify_type' => 1,
                    'product_id' => 1,
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'party_id' => 2,
                    'modify_type' => 0,
                    'product_id' => 2,
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'party_id' => 1,
                    'modify_type' => 1,
                    'product_id' => 2,
                    'made_by' => 2,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
