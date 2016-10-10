<?php

use Illuminate\Database\Seeder;

class BonusesTypeSeeder extends Seeder
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
        DB::table('dev_bonuses_type')->delete();

        /**
         * Inserting
         */
        DB::table('dev_bonuses_type')->insert(
            array(
                array(
                    'id' => 1,
                    'name' => 'Бонус регистрации'
                ),
                array(
                    'id' => 2,
                    'name' => 'Бонус первой покупки'
                ),
                array(
                    'id' => 3,
                    'name' => 'Халява'
                )
            )
        );
    }
}
