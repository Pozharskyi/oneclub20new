<?php

use Illuminate\Database\Seeder;

class IndexStockSeeder extends Seeder
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
        DB::table('dev_index_stock')->delete();

        /**
         * Inserting
         */
        DB::table('dev_index_stock')->insert(
            array(
                array(
                    'id' => 1,
                    'stock' => 'Интернет магазин',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'stock' => 'На складе',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
