<?php

use Illuminate\Database\Seeder;

class DiscountUserTableSeeder extends Seeder
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
        DB::table('dev_discount_user')->delete();

        /**
         * Inserting
         */
        DB::table('dev_discount_user')->insert(
            array(
                array(
                    'id' => 1,
                    'discount_id' => 1,
                    'user_id' => 3,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                )
            )
        );
    }
}
