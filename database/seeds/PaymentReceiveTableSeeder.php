<?php

use Illuminate\Database\Seeder;

class PaymentReceiveTableSeeder extends Seeder
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
        DB::table('dev_payments_receives')->delete();

        /**
         * Inserting
         */
        DB::table('dev_payments_receives')->insert(
            array(
                array(
                    'id' => 1,
                    'paytype' => 'Наличными',
                    'pay_system_order_id' => '1419-9114-9141-0331',
                    'email' => 'serdiuk@gmail.com',
                    'phone' => '380950948268',
                    'ip' => '192.85.195.21',
                    'amount' => '18000',
                    'commission' => '500',
                    'currency' => 'UAH',
                    'description' => 'Описание',
                    'type' => 'Cash',
                    'transaction_id' => '20009515815',
                    'orderDateTime' => date('Y-m-d', strtotime('yesterday')),
                    'payment_status' => '5',
                    'created_at' => date('Y-m-d', strtotime('yesterday')),
                    'updated_at' => date('Y-m-d', strtotime('yesterday')),
                ),
                array(
                    'id' => 2,
                    'paytype' => 'Наличными',
                    'pay_system_order_id' => '7189-9141-6164-7777',
                    'email' => 'serdiuk.oleksandr@gmail.com',
                    'phone' => '380950948268',
                    'ip' => '192.85.195.21',
                    'amount' => '14000',
                    'commission' => '400',
                    'currency' => 'UAH',
                    'description' => 'Описание',
                    'type' => 'Cash',
                    'transaction_id' => '20009515815',
                    'orderDateTime' => date('Y-m-d'),
                    'payment_status' => '5',
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ),
            )
        );
    }
}
