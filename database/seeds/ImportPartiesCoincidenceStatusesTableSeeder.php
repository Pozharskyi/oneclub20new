<?php

use Illuminate\Database\Seeder;

class ImportPartiesCoincidenceStatusesTableSeeder extends Seeder
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
        DB::table('dev_import_parties_coincidence_statuses')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_coincidence_statuses')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Найден у текущего поставщика',
                    'short_phrase' => 'OWN_FOUND',
                    'import_color' => 'green',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'Найден у другого поставщика',
                    'short_phrase' => 'OTHERS_FOUND',
                    'import_color' => 'yellow',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'name' => 'Новый товар',
                    'short_phrase' => 'NEW_ITEM',
                    'import_color' => 'red',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
