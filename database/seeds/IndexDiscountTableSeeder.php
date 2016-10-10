<?php

use Illuminate\Database\Seeder;

class IndexDiscountTableSeeder extends Seeder
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
        DB::table('dev_index_discounts')->delete();

        /**
         * Inserting
         */
        DB::table('dev_index_discounts')->insert(
            array(
                array(
                    'id' => 1,
                    'discount_id' => '124adm124amkdwLda',
                    'discount_amount' => '25',
                    'active_from' => '2016-08-01 01:01:01',
                    'active_to' => '2016-12-01 01:01:01',
                    'status' => 'Активный',
                    'comment' => 'test comment 1',
                    'rule' => 'rule name 1',
                    'auto' => '0',
                    'type' => 'money',
                    'min_basket_sum' => 500,
                    'max_basket_sum' => 0,
                    'purchase_number' => 0,
                    'coupon_rules_id' => 1,
                    'subproduct_amount_from' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'discount_id' => 'dam513mpdaDDa19',
                    'discount_amount' => '350',
                    'active_from' => '2016-08-01 01:01:01',
                    'active_to' => '2016-12-01 01:01:01',
                    'status' => 'Активный',
                    'comment' => 'test comment 2',
                    'rule' => 'rule name 2',
                    'auto' => '0',
                    'type' => 'money',
                    'min_basket_sum' => 1000,
                    'max_basket_sum' => 0,
                    'purchase_number' => 0,
                    'coupon_rules_id' => 2,
                    'subproduct_amount_from' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'discount_id' => 'damkpw4193laddaw',
                    'discount_amount' => '16',
                    'active_from' => '2016-08-01 01:01:01',
                    'active_to' => '2016-12-01 01:01:01',
                    'status' => 'Активный',
                    'comment' => 'test comment 3',
                    'rule' => 'rule name 3',
                    'auto' => '1',
                    'type' => 'percent',
                    'min_basket_sum' => 2000,
                    'max_basket_sum' => 0,
                    'purchase_number' => 0,
                    'coupon_rules_id' => 3,
                    'subproduct_amount_from' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
