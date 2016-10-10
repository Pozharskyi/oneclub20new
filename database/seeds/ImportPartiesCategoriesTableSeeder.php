<?php

use Illuminate\Database\Seeder;

class ImportPartiesCategoriesTableSeeder extends Seeder
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
        DB::table('dev_import_parties_categories')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_categories')->insert(
            array(
                array(
                    'id' => 1,
                    'type' => 'Каталог',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'type' => 'Скидки',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
