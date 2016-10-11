<?php

use Illuminate\Database\Seeder;

class ImportPartiesPrepareStatusesTableSeeder extends Seeder
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
        DB::table('dev_import_parties_prepare_statuses')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_prepare_statuses')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Успешно пройдена проверка',
                    'short_phrase' => 'OK',
                    'file_column_name' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'Баркод уже существует',
                    'short_phrase' => 'BARCODE_EXISTS',
                    'file_column_name' => 'barcode',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'name' => 'Категория 1 не найдена',
                    'short_phrase' => 'CAT1_NOT_FOUND',
                    'file_column_name' => 'cat1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'name' => 'Категория 2 не найдена',
                    'short_phrase' => 'CAT2_NOT_FOUND',
                    'file_column_name' => 'cat2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'name' => 'Категория 3 не найдена',
                    'short_phrase' => 'CAT3_NOT_FOUND',
                    'file_column_name' => 'cat3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'name' => 'Размера не найдено',
                    'short_phrase' => 'SIZE_NOT_FOUND',
                    'file_column_name' => 'size',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 7,
                    'name' => 'Количество не может быть отрицательным',
                    'short_phrase' => 'QUANTITY_NOT_NEGATIVE',
                    'file_column_name' => 'quantity',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 8,
                    'name' => 'Бренд не найден',
                    'short_phrase' => 'BRAND_NOT_FOUND',
                    'file_column_name' => 'brand',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 9,
                    'name' => 'Количество не может быть отрицательным',
                    'short_phrase' => 'QUANTITY_NOT_NEGATIVE',
                    'file_column_name' => 'quantity',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 10,
                    'name' => 'Гендер не найден',
                    'short_phrase' => 'GENDER_NOT_FOUND',
                    'file_column_name' => 'gender',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 11,
                    'name' => 'Цвет не найден',
                    'short_phrase' => 'COLOR_NOT_FOUND',
                    'file_column_name' => 'color',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
