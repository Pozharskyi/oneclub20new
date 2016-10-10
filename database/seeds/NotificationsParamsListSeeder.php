<?php

use Illuminate\Database\Seeder;

class NotificationsParamsListSeeder extends Seeder
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
        DB::table('dev_notifications_params_list')->delete();

        /**
         * Inserting
         */
        DB::table('dev_notifications_params_list')->insert(
            array(
                array(
                    'id' => 1,
                    'name' => 'Полное имя пользователя',
                    'template_name' => '%TEMPLATE.full_name%',
                    'template_variable' => 'full_name',
                    'method_name' => 'getFullName',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'name' => 'Имя пользователя',
                    'template_name' => '%TEMPLATE.f_name%',
                    'template_variable' => 'f_name',
                    'method_name' => 'getFirstName',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'name' => 'Фамилия пользователя',
                    'template_name' => '%TEMPLATE.l_name%',
                    'template_variable' => 'l_name',
                    'method_name' => 'getLastName',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
