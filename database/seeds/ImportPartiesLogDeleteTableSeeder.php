<?php

use Illuminate\Database\Seeder;

class ImportPartiesLogDeleteTableSeeder extends Seeder
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
        DB::table('dev_import_parties_log_delete')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_log_delete')->insert(
            [
                [
                    'id' => 1,
                    'import_index_party_id' => '1',
                    'comment' => 'Название не соответствует продуктам',
                    'is_approved' => 'Подтвержден',
                    'made_by' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'import_index_party_id' => '2',
                    'comment' => 'Случайно добавленная товарная партия',
                    'is_approved' => 'Подтвержден',
                    'made_by' => '2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
