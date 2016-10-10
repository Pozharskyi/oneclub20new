<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 14:46
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Product\ProductIndexPricesModel;
use App\Models\Product\ProductPriceModel;

/**
 * Main Import Handler for prices
 * of sub products
 * Includes switching product prices, creating new ones
 * Calculator of Discount as well as Product Marga
 * Updating and Creation
 * Class AdminImportPricesTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportPricesTrait
{
    /**
     * Creating prices for sub product
     * based on all available prices
     * @param AdminImportStageController $stage
     * @param $pricesArray
     */
    public function actionCreatePriceForSubProduct(AdminImportStageController $stage, $pricesArray)
    {
        if ($pricesArray['sale_percent'] != '') {
            $salePercent = $pricesArray['sale_percent'];
        } else {
            $salePercent = round(($pricesArray['special_price'] / $pricesArray['final_price']) * 100, 2);
        }

        $marga = $pricesArray['index_price'] - $pricesArray['special_price'];
        $pricesArray['product_marga'] = $marga;
        $pricesArray['sale_percent'] = $salePercent;

        try {
            // Trying to create prices row
            ProductPriceModel::create($pricesArray);
        } catch (\Exception $e) {
            // Force push Error message
            $stage->actionNotForcePush('ERROR', 'Проблема с добавлением цен для продукта.');
        }
    }

    /**
     * Searching product prices
     * for existing product
     * @param $sub_product_id
     * @return mixed
     */
    public function actionSearchProductPrices( $sub_product_id )
    {
        $product = ProductIndexPricesModel::where( 'sub_product_id', $sub_product_id )
            ->first();

        return $product;
    }

    /**
     * Updating sub product prices
     * based on array to commit
     * @param $sub_product_id
     * @param $array
     */
    public function actionUpdateSubProductPrices( $sub_product_id, $array )
    {
        ProductIndexPricesModel::where( 'sub_product_id', $sub_product_id )
            ->update( $array );
    }

    /**
     * Updating product prices
     * if product exists make prices
     * If Marga or percent not defined
     * calculate them
     * @param $sub_product_id
     * @param $prices
     */
    public function actionUpdatePrices( $sub_product_id, $prices )
    {
        $updateArray = array();
        $parentPrices = $this->actionSearchProductPrices( $sub_product_id );

        foreach( $prices as $row => $data )
        {
            if( $data != '' )
            {
                $updateArray[$row] = $data;
            }
        }

        // calculating sale percent
        $updateArray['sale_percent'] = $this->actionValidateSalePercent( $prices, $parentPrices );

        // calculating product marga
        $updateArray['product_marga'] = $this->actionValidateMarga( $prices, $parentPrices );

        // if any field needle to fulfill
        if( !empty( $updateArray ) )
        {
            ProductPriceModel::where( 'sub_product_id', $sub_product_id )
                ->update( $updateArray );
        }
    }

    /**
     * Getting product marga
     * Calculation process
     * @param $prices
     * @param $parentPrices
     * @return mixed
     */
    private function actionValidateMarga( $prices, $parentPrices )
    {
        if( $prices['index_price'] != '' && $prices['special_price'] != '' )
        {
            $product_marga = $prices['special_price'] - $prices['index_price'];
        } elseif( $prices['index_price'] != '' && $prices['special_price'] == '' )
        {
            $product_marga = $parentPrices->special_price - $prices['index_price'];
        } elseif( $prices['index_price'] == '' && $prices['special_price'] != '' )
        {
            $product_marga = $prices['special_price'] - $parentPrices->index_price;
        } else
        {
            $product_marga = $parentPrices->special_price - $parentPrices->index_price;
        }

        return $product_marga;
    }

    /**
     * Getting product discount
     * Calculation process
     * @param $prices
     * @param $parentPrices
     * @return float
     */
    private function actionValidateSalePercent( $prices, $parentPrices )
    {
        if( $prices['sale_percent'] == '' )
        {
            if( $prices['final_price'] != '' && $prices['special_price'] != '' )
            {
                $sale_percent = round( ( $prices['special_price'] * 100 ) / $prices['final_price'] );
            } elseif( $prices['final_price'] != '' && $prices['special_price'] == '' )
            {
                $sale_percent = round( ( $parentPrices->special_price * 100 ) / $prices['final_price'] );
            } elseif( $prices['final_price'] == '' && $prices['special_price'] != '' )
            {
                $sale_percent = round( ( $prices['special_price'] * 100 ) / $parentPrices->final_price );
            } else
            {
                $sale_percent = round( ( $parentPrices->special_price * 100 ) / $parentPrices->final_price );
            }

            return $sale_percent;

        } else
        {
            return $prices['sale_percent'];
        }
    }

}