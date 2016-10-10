<?php

use Illuminate\Database\Seeder;

class OrderIndexSeeder extends Seeder
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
        DB::table('dev_order_index')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_index')->insert(
            array(
                array(
                    'id' => 1,
                    'user_id' => 1,
                    'payment_type_id' => 1,
                    'public_order_id' => '1419-9114-9141-0331',
                    'discount_id' => 1,
                    'comment' => 'Test order 1',
                    'total_sum' => 300,
                    'original_sum' => 300,
                    'total_quantity' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'user_id' => 2,
                    'payment_type_id' => 2,
                    'public_order_id' => '7189-9141-6164-7777',
                    'discount_id' => null,
                    'comment' => 'Test order 2',
                    'total_sum' => 290,
                    'original_sum' => 300,
                    'total_quantity' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s', strtotime('yesterday')),
                ),
            )
        );
    }
}
