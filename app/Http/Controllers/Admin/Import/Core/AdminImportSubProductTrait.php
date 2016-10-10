<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 14:32
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Product\ProductPopularityModel;
use App\Models\Product\SubProductModel;

/**
 * Main package manager for handle
 * Sub Product Attributes
 * Includes creation, finding, updating
 * and handler for popularity
 * Includes error reporting
 * Class AdminImportSubProductTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportSubProductTrait
{
    use AdminImportProductColorsTrait;
    use AdminImportProductSizesTrait;

    /**
     * If product exists make alert
     * that this product already exists
     * Else create new product and
     * return id
     * @param AdminImportStageController $stage
     * @param $subProductArray
     * @return bool|mixed
     */
    public function actionCreateSubProduct(AdminImportStageController $stage, $subProductArray)
    {
        $barcode = $subProductArray['barcode'];
        // find product
        $find = $this->actionFindSubProduct($barcode);

        if ($find === false) {
            $subProduct = SubProductModel::create($subProductArray);

            $result = new \stdClass();
            $result->id = $subProduct->id;
            $result->found = 0;

            return $result;
        } else {
            // make Error alert
            $stage->actionPushStage('ERROR', 'Данный продукт с баркодом номер ' . $barcode . ' уже существует.');

            // return $find;
            return false;
        }
    }

    /**
     * Finding Sub Product by barcode
     * If found return id
     * Else return bool
     * @param $barcode
     * @return bool
     */
    public function actionFindSubProduct($barcode)
    {
        $subProduct = SubProductModel::search($barcode)
            ->first(['id']);

        if (isset($subProduct->id)) {
            return $subProduct->id;
        } else {
            return false;
        }
    }

    /**
     * Search exact matching for product
     * If color or size does not exists make error alert
     * If found return id
     * else return bool
     * @param AdminImportStageController $stage
     * @param $product_id
     * @param $barcode
     * @param $color
     * @param $size
     * @return bool
     */
    public function actionSearchSubProduct( AdminImportStageController $stage, $product_id, $barcode, $color, $size )
    {
        $color_id = $this->actionFindColorByName( $color, $stage );
        $size_id = $this->actionFindSizeByName( $size, $stage );

        $sub_product = SubProductModel::finalSearch( $product_id, $barcode, $color_id, $size_id )
            ->first(['id']);

        if( isset( $sub_product->id ) )
        {
            return $sub_product->id;
        } else
        {
            return false;
        }
    }

    /**
     * Updating sub product Attributes
     * based on Request input array
     * If array if empty just skip
     * else Update
     * @param $sub_product_id
     * @param $sub_product_data
     */
    public function actionUpdateSubProduct( $sub_product_id, $sub_product_data )
    {
        $updateArray = array();

        // getting fields for update
        foreach( $sub_product_data as $row => $data )
        {
            if( $data != '' )
            {
                $updateArray[$row] = $data;
            }
        }

        // if array not empty
        // make update
        if( !empty( $updateArray ) )
        {
            SubProductModel::findOrFail( $sub_product_id )
                ->update( $updateArray );
        }
    }

    /**
     * Inserting popularity for Sub Product
     * with zero count
     * If any error return false
     * else return true
     * @param AdminImportStageController $stage
     * @param $sub_product_id
     * @return bool
     */
    public function actionInsertPopularity( AdminImportStageController $stage, $sub_product_id )
    {
        try
        {
            ProductPopularityModel::create([
                'sub_product_id' => $sub_product_id,
                'popularity' => 0,
            ]);
        } catch( \Exception $e )
        {
            return false;
        }

        return true;
    }

    /**
     * Getting products for parties
     * Based on party identify
     * @param $partyId
     * @return mixed
     */
    public function actionGetProducts($partyId)
    {
        $products = SubProductModel::where( 'dev_import_parties_id', $partyId )
            ->with(['product', 'price', 'color', 'size', 'photos'])
            ->get();

        return $products;
    }
}