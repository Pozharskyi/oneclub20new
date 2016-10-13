<?php

use Illuminate\Database\Seeder;

class OrderDeliverySeeder extends Seeder
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
        DB::table('dev_order_delivery')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_delivery')->insert(
            array(
                array(
                    'id' => 1,
                    'order_id' => 1,
                    'delivery_type_id' => 1,
                    'delivery_f_name' => 'Елена',
                    'delivery_l_name' => 'Гонтарева',
                    'delivery_phone' => '950950951',
                    'delivery_address' => 'ул. Маршала Тимошенка 5/7 кв. 91',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'order_id' => 2,
                    'delivery_type_id' => 3,
                    'delivery_f_name' => 'Михаил',
                    'delivery_l_name' => 'Бачкур',
                    'delivery_phone' => '951112233',
                    'delivery_address' => 'ул. Деловая 5, кв. 111',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
