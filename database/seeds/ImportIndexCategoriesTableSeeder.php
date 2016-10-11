<?php

use Illuminate\Database\Seeder;

class ImportIndexCategoriesTableSeeder extends Seeder
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
        DB::table('dev_import_index_categories')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_index_categories')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Каталог',
                    'short_association' => 'CATALOG',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => '% Скидки',
                    'short_association' => 'SALE',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
