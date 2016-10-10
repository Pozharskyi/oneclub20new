<?php

use Illuminate\Database\Seeder;

class OrderStatusListTableSeeder extends Seeder
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
        DB::table('dev_order_status_list')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_status_list')->insert(
            array(
                array(
                    'id' => 1,
                    'user_status' => 'Новый',
                    'admin_status'  =>  'Новый',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'user_status' => 'Новый',
                    'admin_status'  =>  'Недозвон',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'user_status' => 'Новый',
                    'admin_status'  =>  'Перезвон',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 4,
                    'user_status' => 'Уточнение',
                    'admin_status'  =>  'Уточнение',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 5,
                    'user_status' => 'Подтвержден',
                    'admin_status'  =>  'Подтвержден',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 6,
                    'user_status' => 'Подтвержден',
                    'admin_status'  =>  'Заказ отправлен поставщику',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 7,
                    'user_status' => 'Подтвержден',
                    'admin_status'  =>  'В ожидании поставки',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 8,
                    'user_status' => 'Подтвержден',
                    'admin_status'  =>  'Заказ доставлен на склад',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 9,
                    'user_status' => 'Подтвержден',
                    'admin_status'  =>  'Товар приянт на склад',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 10,
                    'user_status' => 'Подтвержден',
                    'admin_status'  =>  'Готов к упаковке',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 11,
                    'user_status' => 'Упакован',
                    'admin_status'  =>  'Упакован',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 12,
                    'user_status' => 'Передан курьерской службе',
                    'admin_status'  =>  'Передан курьерской службе',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 13,
                    'user_status' => 'Доставлен в пункт самовывоза',
                    'admin_status'  =>  'Доставлен в пункт самовывоза',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 14,
                    'user_status' => 'Доставлен в отделение НП',
                    'admin_status'  =>  'Доставлен в отделение НП',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 15,
                    'user_status' => 'Доставлен и оплачен',
                    'admin_status'  =>  'Доставлен и оплачен',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 16,
                    'user_status' => 'Отменен',
                    'admin_status'  =>  'Отменен',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 17,
                    'user_status' => 'Возврат',
                    'admin_status'  =>  'Возврат',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 18,
                    'user_status' => 'Деньги возвращены',
                    'admin_status'  =>  'Деньги возвращены',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),

            )
        );
    }
}
