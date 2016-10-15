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
                    'short_phrase' => 'FOUND',
                    'import_color' => 'green',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'Нет описания',
                    'short_phrase' => 'DESCRIPTION',
                    'import_color' => 'blue',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'name' => 'Нет фото',
                    'short_phrase' => 'PHOTO',
                    'import_color' => 'yellow',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'name' => 'Новая карта',
                    'short_phrase' => 'NEW',
                    'import_color' => 'purple',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
