<?php

use Illuminate\Database\Seeder;

class ProductDimensionsTableSeeder extends Seeder
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
        DB::table('dev_product_dimensions')->delete();

        /**
         * Inserting
         */
        DB::table('dev_product_dimensions')->insert(
            array(
                array(
                    'id' => 1,
                    'product_id' => 1,
                    'product_colors' => '{"colors":[{"color":"green"},{"color":"red"}]}',
                    'product_sizes' => '{"sizes":[{"size":"M"}]}',
                    'product_photos' => '{"photos":[{"photo":"http://oneclub.ua/media/catalog/product/cache/1/small_image/1140x1710/9df78eab33525d08d6e5fb8d27136e95/i/m/img_0454_3.jpg"},{"photo":"http://oneclub.ua/media/catalog/product/cache/1/small_image/1140x1710/9df78eab33525d08d6e5fb8d27136e95/i/m/img_0455.jpg"}]}',
                    'product_total_quantity' => 4,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
                array(
                    'id' => 2,
                    'product_id' => 2,
                    'product_colors' => '{"colors":[{"color":"green"}]}',
                    'product_sizes' => '{"sizes":[{"size":"S"}]}',
                    'product_photos' => '{"photos":[{"photo":"http://oneclub.ua/media/catalog/product/cache/1/small_image/1140x1710/9df78eab33525d08d6e5fb8d27136e95/i/m/img_0270_4.jpg"}]}',
                    'product_total_quantity' => 10,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
