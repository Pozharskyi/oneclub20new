<?php

use App\Models\Order\OrderContactDetailsModel;
use Illuminate\Database\Seeder;

class LogOrderTableSeeder extends Seeder
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
        DB::table('dev_order_log')->delete();

        /**
         * Inserting
         */
        DB::table('dev_order_log')->insert(
            [
                [
                    'id' => 1,
                    'author_id' => 2,
                    'order_id' =>1,
                    'action_id' => 1,
                    'field_changed' => 'comment',
                    'fromto_id' => 2,
                    'fromto_type' => 'App\Models\Loging\LogFromToStringModel',
                    'date' => date('Y-m-d H:i:s'),
                    'loggable_type' => OrderContactDetailsModel::class,
                    'loggable_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
