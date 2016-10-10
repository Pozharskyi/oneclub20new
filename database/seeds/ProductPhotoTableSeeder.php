<?php

use Illuminate\Database\Seeder;

class ProductPhotoTableSeeder extends Seeder
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
        DB::table('dev_product_photo')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_photo')->insert(
            [
                [
                    'id' => 1,
                    'photo' => 'http://oneclub.ua/media/catalog/product/cache/1/small_image/1140x1710/9df78eab33525d08d6e5fb8d27136e95/d/s/dsc_0976_4.jpg',
                    'sub_product_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'photo' => 'http://oneclub.ua/media/catalog/product/cache/1/small_image/378x548/9df78eab33525d08d6e5fb8d27136e95/d/s/dsc_1096_1.jpg',
                    'sub_product_id' => 3,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'photo' => 'http://oneclub.ua/media/catalog/product/cache/1/small_image/378x548/9df78eab33525d08d6e5fb8d27136e95/d/s/dsc_0836_8.jpg',
                    'sub_product_id' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
