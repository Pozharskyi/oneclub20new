<?php

use Illuminate\Database\Seeder;

class UserIndexCategoriesTableSeeder extends Seeder
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
        DB::table('dev_users_index_categories')->delete();

        /**
         * Inserting
         */
        DB::table('dev_users_index_categories')->insert(
            [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'category_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'user_id' => 2,
                    'category_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
