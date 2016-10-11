<?php

use Illuminate\Database\Seeder;

class ImportPartiesStatusesTableSeeder extends Seeder
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
        DB::table('dev_import_parties_statuses')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_statuses')->insert(
            [
                [
                    'id' => 1,
                    'parties_status' => 'Отправлено в продакшн',
                    'short_phrase' => 'PROCESSING',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'parties_status' => 'Готово',
                    'short_phrase' => 'READY',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'parties_status' => 'Привязано к Товарной Акции',
                    'short_phrase' => 'TA',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'parties_status' => 'Отправлено в маркетинг',
                    'short_phrase' => 'MARKETING',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'parties_status' => 'Отправлено в каталог',
                    'short_phrase' => 'CATALOG',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'parties_status' => 'Не использованная товарная партия',
                    'short_phrase' => 'NEW',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
