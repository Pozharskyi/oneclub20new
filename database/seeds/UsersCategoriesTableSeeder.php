<?php

use Illuminate\Database\Seeder;

class UsersCategoriesTableSeeder extends Seeder
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
        DB::table('dev_users_categories')->delete();

        /**
         * Inserting
         */
        DB::table('dev_users_categories')->insert(
            array(
                array(
                    'id' => 1,
                    'category' => 'Basic',
                    'min_price' => '0',
                    'max_price' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'category' => 'Standart',
                    'min_price' => '0',
                    'max_price' => '1500',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'category' => 'VIP',
                    'min_price' => '1501',
                    'max_price' => '3000',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
