<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
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
        DB::table('dev_supplier')->delete();

        /**
         * Inserting
         */
        DB::table('dev_supplier')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'OC2.0 Supplier1',
                    'shop' => 'Oneclub',
                    'contact_person' => 'Any',
                    'brands' => 'Dirk',
                    'phones' => '380950948268',
                    'email' => 'serdiuk@gmail.com',
                    'coefficient' => '1.25 - 1.4',
                    'product_marga' => '25%',
                    'time_of_returns' => 'По белью - 9 дней; Одежда, обувь и т.д. - 21 день',
                    'work_status' => 'Работаем',
                    'work_comment' => '',
                    'agreement' => 'Есть',
                    'start_working' => '12/1/2015',
                    'payment_form' => 'Наличные',
                    'payment_postpone' => '21',
                    'ecommerce_comment' => '',
                    'address_sending' => 'Компекс Киев 1',
                    'logistic_comment' => '',
                    'address_return' => 'Комплекс Киев 2',
                    'products_category' => 'Детская одежда, мужская и женская одежда и аксессуары. Товары для дома',
                    'buyer_id' => 1,
                    'made_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'name' => 'OC2.0 Supplier 2',
                    'shop' => 'Oneclub',
                    'contact_person' => 'Any',
                    'brands' => 'Dirk',
                    'phones' => '380950948268',
                    'email' => 'serdiuk.oleksandr@gmail.com',
                    'coefficient' => '1.25 - 1.4',
                    'product_marga' => '25%',
                    'time_of_returns' => 'По белью - 9 дней; Одежда, обувь и т.д. - 21 день',
                    'work_status' => 'Работаем',
                    'work_comment' => '',
                    'agreement' => 'Есть',
                    'start_working' => '12/1/2015',
                    'payment_form' => 'Наличные',
                    'payment_postpone' => '21',
                    'ecommerce_comment' => '',
                    'address_sending' => 'Компекс Киев 4',
                    'logistic_comment' => '',
                    'address_return' => 'Комплекс Киев 7',
                    'products_category' => 'Детская одежда, мужская и женская одежда и аксессуары. Товары для дома',
                    'buyer_id' => 1,
                    'made_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'name' => 'OC2.0 Supplier 3',
                    'shop' => 'Oneclub',
                    'contact_person' => 'Any',
                    'brands' => 'Dirk',
                    'phones' => '380950948268',
                    'email' => 'serdiuk.new@gmail.com',
                    'coefficient' => '1.25 - 1.4',
                    'product_marga' => '25%',
                    'time_of_returns' => 'По белью - 9 дней; Одежда, обувь и т.д. - 21 день',
                    'work_status' => 'Работаем',
                    'work_comment' => '',
                    'agreement' => 'Есть',
                    'start_working' => '12/1/2016',
                    'payment_form' => 'Наличные',
                    'payment_postpone' => '15',
                    'ecommerce_comment' => '',
                    'address_sending' => 'Компекс Donetsk 1',
                    'logistic_comment' => '',
                    'address_return' => 'Комплекс Donetsk 2',
                    'products_category' => 'Детская одежда, мужская и женская одежда и аксессуары. Товары для дома',
                    'buyer_id' => 1,
                    'made_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
