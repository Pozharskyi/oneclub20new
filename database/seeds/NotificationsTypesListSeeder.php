<?php

use Illuminate\Database\Seeder;

class NotificationsTypesListSeeder extends Seeder
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
        DB::table('dev_notifications_types_list')->delete();

        /**
         * Inserting
         */
        DB::table('dev_notifications_types_list')->insert(
            array(
                array(
                    'id' => 1,
                    'notification_type' => 'Email',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'notification_type' => 'Message',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 3,
                    'notification_type' => 'Web-push',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
