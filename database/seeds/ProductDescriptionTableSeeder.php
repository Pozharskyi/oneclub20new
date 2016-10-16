<?php

use Illuminate\Database\Seeder;

class ProductDescriptionTableSeeder extends Seeder
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
        DB::table('dev_product_description')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_description')->insert(
            array(
                array(
                    'id' => 1,
                    'product_id' => 1,
                    'supplier_product_name' => 'ZZZ Taylor',
                    'product_description' => 'Test product 1',
                    'product_composition' => 'Test composition 1',
                    'comment_admin' => 'Тест тест тест',
                    'comment_frontend' => 'Скидка не предоставляется',
                    'country_manufacturer' => 'Испания',
                    'product_delivery_days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'product_id' => 2,
                    'supplier_product_name' => 'ZZZ Homie',
                    'product_description' => 'Test product 2',
                    'product_composition' => 'Test composition 2',
                    'comment_admin' => 'Тест комментарий для админа',
                    'comment_frontend' => 'Тест комментарий для UI',
                    'country_manufacturer' => 'Италия',
                    'product_delivery_days' => 6,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
