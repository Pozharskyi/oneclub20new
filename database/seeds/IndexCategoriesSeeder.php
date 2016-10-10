<?php

use Illuminate\Database\Seeder;

class IndexCategoriesSeeder extends Seeder
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
        DB::table('dev_index_categories')->delete();

        /**
         * Inserting
         */
        DB::table('dev_index_categories')->insert(
            array(
                array(
                    'id' => 1,
                    'category_name' => 'Мужчинам',
                    'parent_id' => 0,
                    'made_by' => 1,
                    'shortcut' => 'men',
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'category_name' => 'Женщинам',
                    'parent_id' => 0,
                    'made_by' => 1,
                    'shortcut' => 'women',
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'category_name' => 'Детям',
                    'parent_id' => 0,
                    'made_by' => 1,
                    'shortcut' => 'children',
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 4,
                    'category_name' => 'Косметика',
                    'parent_id' => 0,
                    'made_by' => 1,
                    'shortcut' => 'cosmetic',
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 5,
                    'category_name' => 'Для дома',
                    'parent_id' => 0,
                    'made_by' => 1,
                    'shortcut' => 'home',
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 6,
                    'category_name' => 'Одежда',
                    'parent_id' => 1,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 7,
                    'category_name' => 'Нижнее белье и одежда для дома',
                    'parent_id' => 6,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 8,
                    'category_name' => 'Одежда',
                    'parent_id' => 2,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 9,
                    'category_name' => 'Жакеты',
                    'parent_id' => 8,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 10,
                    'category_name' => 'Верхняя одежда',
                    'parent_id' => 1,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 11,
                    'category_name' => 'Куртки и жилеты',
                    'parent_id' => 10,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 12,
                    'category_name' => 'Блузы и свитера',
                    'parent_id' => 6,
                    'made_by' => 1,
                    'shortcut' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                )
            )
        );
    }
}
