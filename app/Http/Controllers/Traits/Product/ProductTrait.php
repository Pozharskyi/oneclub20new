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
use App\Models\Product\ProductModel;

trait ProductTrait
{
    public function actionGetProducts( $supplierId )
    {
        $parties = PartiesController::actionGetAllParties( $supplierId );

        $products = ProductModel::filterByParties( $parties )
            ->with(['description'])
            ->get();

        return $products;
    }

    public function actionGetTotalMatch($products, $fields)
    {
        foreach( $products as $product )
        {
            if ($product->sku == $fields['sku'] && $product->category_id == $fields['category_id'] &&
                $product->brand_id == $fields['brand_id'] &&
                $product->dev_product_color_id == $fields['dev_product_color_id']
            ) {
                return true;
            }
        }

        return false;
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

}