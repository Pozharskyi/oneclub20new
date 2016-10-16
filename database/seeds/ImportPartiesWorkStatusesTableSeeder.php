<?php

use Illuminate\Database\Seeder;

class ImportPartiesWorkStatusesTableSeeder extends Seeder
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
        DB::table('dev_import_parties_work_statuses')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_work_statuses')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Проверенный товар',
                    'short_phrase' => 'APPROVED',
                    'import_color' => 'green',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'Отправлен на фотосьему',
                    'short_phrase' => 'PHOTO',
                    'import_color' => 'yellow',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'name' => 'Отправлен контенщикам',
                    'short_phrase' => 'CONTENT',
                    'import_color' => 'black',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
