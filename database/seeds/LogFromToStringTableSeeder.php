<?php

use Illuminate\Database\Seeder;

class LogFromToStringTableSeeder extends Seeder
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
        DB::table('dev_log_from_to_string')->delete();

        /**
         * Inserting
         */
        DB::table('dev_log_from_to_string')->insert(
            [
                [
                    'id' => 1,
                    'from' => 'Name A',
                    'to' => 'Name B',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'from' => '',
                    'to' => 'Бонус за регистрацию',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'from' => '',
                    'to' => 'Бонус за регистрацию',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'from' => '',
                    'to' => 'Бонус за регистрацию',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'from' => 'Бонус за регистрацию',
                    'to' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'from' => '1',
                    'to' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
