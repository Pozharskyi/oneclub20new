<?php

use Illuminate\Database\Seeder;

class ImportLogSalesAssociationTableSeeder extends Seeder
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
        DB::table('dev_import_log_sales_association')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_log_sales_association')->insert(
            array(
                array(
                    'id' => 1,
                    'sales_association_id' => 1,
                    'modify_type' => 1,
                    'party_id' => 1,
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'sales_association_id' => 2,
                    'modify_type' => 0,
                    'party_id' => 1,
                    'made_by' => 1,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'sales_association_id' => 1,
                    'modify_type' => 1,
                    'party_id' => 1,
                    'made_by' => 2,

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
