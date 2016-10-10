<?php

use Illuminate\Database\Seeder;

class ImportFatStatusTableSeeder extends Seeder
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
        DB::table('dev_import_fat_status')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_fat_status')->insert(
            array(
                array(
                    'id' => 1,
                    'fat_status' => 'Найдено в товарах поставщика',
                    'short_phrase' => 'OWN_FOUND',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'fat_status' => 'Найдено в товарах другого поставщика',
                    'short_phrase' => 'OTHERS_FOUND',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'fat_status' => 'Новый товар',
                    'short_phrase' => 'NEW',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 4,
                    'fat_status' => 'Ошибка',
                    'short_phrase' => 'ERROR',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 5,
                    'fat_status' => 'Предупреждение',
                    'short_phrase' => 'WARNING',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 6,
                    'fat_status' => 'Отправлено на фотосьемку',
                    'short_phrase' => 'PHOTO',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 7,
                    'fat_status' => 'Отправлено контенщикам',
                    'short_phrase' => 'CONTENT',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 8,
                    'fat_status' => 'Проверенный товар',
                    'short_phrase' => 'APPROVED',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 9,
                    'fat_status' => 'Заменен на существующий',
                    'short_phrase' => 'SWITCHED',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 10,
                    'fat_status' => 'Товар был обновлен',
                    'short_phrase' => 'UPDATED',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 11,
                    'fat_status' => 'Товар не был обновлен',
                    'short_phrase' => 'NOT_UPDATED',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 12,
                    'fat_status' => 'Товар не найден',
                    'short_phrase' => 'NOT_FOUND',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 13,
                    'fat_status' => 'Программная ошибка',
                    'short_phrase' => 'SYSTEM_ERROR',

                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )

        );
    }
}
