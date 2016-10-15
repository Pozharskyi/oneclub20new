<?php

use Illuminate\Database\Seeder;

class ImportPartiesPhotosFoundsTableSeeder extends Seeder
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
        DB::table('dev_import_parties_photos_founds')->delete();

        /**
         * Inserting
         */
        DB::table('dev_import_parties_photos_founds')->insert(
            [
                [
                    'id' => 1,
                    'file_allocation_id' => '1',
                    'file_line' => '1',
                    'photo_uri' => '/supplier_id/sku_brand_color.jpeg',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'file_allocation_id' => '1',
                    'file_line' => '2',
                    'photo_uri' => '/supplier_id/sku_brand_color.jpeg',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'file_allocation_id' => '2',
                    'file_line' => '1',
                    'photo_uri' => '/supplier_id/sku_brand_color.jpeg',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
