<?php

use Illuminate\Database\Seeder;

class DiscountUserCategoriesTableSeeder extends Seeder
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
        DB::table('dev_discount_users_categories')->delete();

        /**
         * Inserting
         */
        DB::table('dev_discount_users_categories')->insert(
            array(
                array(
                    'id' => 1,
                    'discount_id' => 1,
                    'users_categories_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'discount_id' => 2,
                    'users_categories_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                )
            )
        );
    }
}
