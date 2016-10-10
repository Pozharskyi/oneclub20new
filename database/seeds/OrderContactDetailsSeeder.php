<?php

use Illuminate\Database\Seeder;

class OrderContactDetailsSeeder extends Seeder
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
        DB::table('dev_order_contact_details')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_contact_details')->insert(
            array(
                array(
                    'id' => 1,
                    'order_id' => 1,
                    'f_name' => 'Александр',
                    'l_name' => 'Сердюк',
                    'city' => 'Киев',
                    'cell' => '950948268',
                    'email' => 'serdiuk@smartdevelopers.eu',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'order_id' => 2,
                    'f_name' => 'Дмитрий',
                    'l_name' => 'Медведев',
                    'city' => 'Мосвка',
                    'cell' => '95145151',
                    'email' => 'medvedev@gov.ru',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
