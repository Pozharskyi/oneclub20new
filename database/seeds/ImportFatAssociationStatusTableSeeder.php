<?php

use Illuminate\Database\Seeder;

class ImportFatAssociationStatusTableSeeder extends Seeder
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
        DB::table('dev_import_fat_association_status')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_fat_association_status')->insert(
            [
                [
                    'id' => 1,
                    'association' => 'Результаты поиска по совпадениям',
                    'comment' => 'Есть 3 вида совпадений: 1) найдено у текущего поставщика 2) найдено у другого поставщика 3) новый товар',
                    'short_phrase' => 'SEARCH',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'association' => 'Результаты поиска по уведовмлениям',
                    'comment' => 'Есть 2 вида уведомлений: 1) ошибка 2) внимание',
                    'short_phrase' => 'NOTICE',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'association' => 'Результаты работы с импортом товарных партий',
                    'comment' => 'Есть 3 вида работы: 1) отправить на фотосьемку 2) отправить на дополнение контента 3) новый товар',
                    'short_phrase' => 'RESULT',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'association' => 'Результаты работы с обновлениям товарных партий',
                    'comment' => 'Есть 2 вида результатов: 1) товар был обновлен 2) товар не был обновлен',
                    'short_phrase' => 'UPDATE',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'association' => 'Результаты работы для отдела дороботок',
                    'comment' => 'Есть 2 вида результатов: 1) нужны фото 2) нужен контент',
                    'short_phrase' => 'WORK',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
