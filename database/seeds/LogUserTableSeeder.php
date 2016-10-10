<?php

use Illuminate\Database\Seeder;

class LogUserTableSeeder extends Seeder
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
        DB::table('dev_user_log')->delete();

        /**
         * Inserting
         */
        DB::table('dev_user_log')->insert(
            [
                [
                    'id' => 1,
                    'author_id' => 2,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'Name',
                    'fromto_id' => 1,
                    'fromto_type' => \App\Models\Loging\LogFromToStringModel::class,
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'author_id' => 1,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_amount',
                    'fromto_id' => 1,
                    'fromto_type' => 'App\Models\Loging\LogFromToIntModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'author_id' => 1,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_comment',
                    'fromto_id' => 2,
                    'fromto_type' => 'App\Models\Loging\LogFromToStringModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'author_id' => 2,
                    'user_id' => 2,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_amount',
                    'fromto_id' => 2,
                    'fromto_type' => 'App\Models\Loging\Models\Loging\LogFromToIntModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'author_id' => 2,
                    'user_id' => 2,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_comment',
                    'fromto_id' => 3,
                    'fromto_type' => 'App\Models\Loging\LogFromToStringModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'author_id' => 3,
                    'user_id' => 3,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_amount',
                    'fromto_id' => 3,
                    'fromto_type' => 'App\Models\Loging\LogFromToIntModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 7,
                    'author_id' => 3,
                    'user_id' => 3,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_comment',
                    'fromto_id' => 4,
                    'fromto_type' => 'App\Models\Loging\LogFromToStringModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 8,
                    'author_id' => 1,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_amount',
                    'fromto_id' => 4,
                    'fromto_type' => 'App\Models\Loging\LogFromToIntModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 9,
                    'author_id' => 1,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_comment',
                    'fromto_id' => 5,
                    'fromto_type' => 'App\Models\Loging\LogFromToStringModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 10,
                    'author_id' => 1,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_amount',
                    'fromto_id' => 5,
                    'fromto_type' => 'App\Models\Loging\LogFromToIntModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 11,
                    'author_id' => 1,
                    'user_id' => 1,
                    'action_id' => 2,
                    'field_changed' => 'bonuses_comment',
                    'fromto_id' => 6,
                    'fromto_type' => 'App\Models\Loging\LogFromToStringModel',
                    'date' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
