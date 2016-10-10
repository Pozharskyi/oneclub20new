<?php

use Illuminate\Database\Seeder;

class UsersCategoriesSalesSeeder extends Seeder
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
        DB::table('dev_users_categories_sales')->delete();

        /**
         * Inserting
         */
        DB::table('dev_users_categories_sales')->insert(
            array(
                array(
                    'id' => 1,
                    'person_category_id' => 1,
                    'brand_id' => 1,
                    'discount' => '25',
                    'product_category' => 1,
                    'product_min_price' => '1500',
                    'product_max_price' => '4000',
                    'product_marga' => '1000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'person_category_id' => 2,
                    'brand_id' => 2,
                    'discount' => '5',
                    'product_category' => 2,
                    'product_min_price' => NULL,
                    'product_max_price' => NULL,
                    'product_marga' => '5000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'person_category_id' => 2,
                    'brand_id' => 3,
                    'discount' => '50',
                    'product_category' => 3,
                    'product_min_price' => '5000',
                    'product_max_price' => NULL,
                    'product_marga' => NULL,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
