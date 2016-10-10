<?php

use Illuminate\Database\Seeder;

class NotificationsIndexSeeder extends Seeder
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
        DB::table('dev_notifications_index')->delete();

        /**
         * Inserting
         */
        DB::table('dev_notifications_index')->insert(
            array(
                array(
                    'id' => 1,
                    'notification_id' => '13',
                    'notification_type_id' => '3',
                    'notification_request_message' => '483134',
                    'notification_params' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'notification_id' => '6',
                    'notification_type_id' => '2',
                    'notification_request_message' => '483127',
                    'notification_params' => '1,3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
