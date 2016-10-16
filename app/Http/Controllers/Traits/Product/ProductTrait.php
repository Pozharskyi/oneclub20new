<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 13:20
 */

namespace App\Http\Controllers\Traits\Product;

use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesController as PartiesController;
use App\Models\Import\ImportPartiesPhotosFoundsModel;
use App\Models\Product\ProductModel;
use App\Http\Controllers\Transliteration\TransliterateController as Transliterator;

trait ProductTrait
{
    private $availableExtension = '.jpeg';

    public function actionGetProducts( $supplierId )
    {
        $parties = PartiesController::actionGetAllParties( $supplierId );

        $products = ProductModel::filterByParties( $parties )
            ->with(['description'])
            ->get();

        return $products;
    }

    public function actionGetTotalMatch($products, $fields, $partyId)
    {
        foreach( $products as $product )
        {
            if ($product->sku == $fields['sku'] && $product->category_id == $fields['category_id'] &&
                $product->brand_id == $fields['brand_id'] &&
                $product->dev_product_color_id == $fields['dev_product_color_id']
            ) {
                $this->actionUpdateProductParty( $product->id, $partyId );

                return true;
            }
        }

        return false;
    }

    public function actionUpdateProductParty( $productId, $partyId )
    {
        $item = ProductModel::findOrFail( $productId );
        $item->import_index_party_id = $partyId;

        $item->save();
    }

    public function actionGetDescriptionMatch($products, $fields)
    {
        foreach( $products as $product )
        {
            if ($product->sku == $fields['sku'])
            {
                if($product->description->product_description != '')
                {
                    return true;
                } else
                {
                    return false;
                }
            }
        }

        // if product is new
        return true;
    }

    public function actionGetNewMatch($products, $fields)
    {
        foreach( $products as $product )
        {
            if ($product->sku == $fields['sku'])
            {
                return false;
            }
        }

        return true;
    }

    public function actionGetPhotosMatch( array $fields, $fileAllocation, $fileLine, $supplierId )
    {
        $base_path = base_path();

        $dir = $base_path . '/public/images/' . $supplierId;
        $uri = '/images/' . $supplierId . '/';

        $expectedFile = $fields['sku'] . '_' . $fields['brand'] . '_' . $fields['color'];
        $transliteratedFile = Transliterator::actionTransliterate($expectedFile);
        $realFile = strtolower($transliteratedFile);

        $found = false;

        if (file_exists($dir) && is_dir($dir)) {
            $images = preg_grep('~\.(jpeg|jpg|png)$~', scandir($dir));

            foreach( $images as $image )
            {
                $lc_image = strtolower($image);

                if (strpos($lc_image, $realFile) !== false)
                {
                    $pushArray = array(
                        'file_allocation_id' => $fileAllocation,
                        'file_line' => $fileLine,
                        'photo_uri' => $uri . $lc_image,
                    );

                    ImportPartiesPhotosFoundsModel::create($pushArray);
                    $found = true;
                }
            }
        }

        return $found;
    }

}