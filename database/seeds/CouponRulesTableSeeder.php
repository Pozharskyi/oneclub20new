<?php

use Illuminate\Database\Seeder;

class CouponRulesTableSeeder extends Seeder
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
        DB::table('dev_coupon_rules')->delete();

        /**
         * Inserting
         */
        DB::table('dev_coupon_rules')->insert(
            array(
                array(
                    'id' => 1,
                    'max_used_all' => 5,
                    'max_used_user' => 3,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'max_used_all' => 7,
                    'max_used_user' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'max_used_all' => 4,
                    'max_used_user' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
