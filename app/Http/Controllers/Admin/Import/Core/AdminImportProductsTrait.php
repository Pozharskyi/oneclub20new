<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 13:29
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Basic\BasicGenderModel;
use App\Models\Product\ProductGenderModel;
use App\Models\Product\ProductModel;
use App\Models\Product\ProductStockModel;
use App\Models\Product\SubProductModel;

/**
 * Main import handler for products
 * Includes finding by sku, getting product with logging
 * Creation of products, genders as well as finding
 * Updating of products
 * Class AdminImportProductsTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportProductsTrait
{
    use AdminImportCodesTrait;

    /**
     * Finding product by sku
     * Return product id
     * @param $sku
     * @return mixed
     */
    public function actionFindProductBySku( $sku )
    {
        $product = ProductModel::where( 'sku', $sku )
            ->first(['id']);

        return $product;
    }

    /**
     * Getting product if find
     * return found as 1 with Warning Alert
     * else return creation process of adding
     * product with new sku
     * @param AdminImportStageController $stage
     * @param $sku
     * @param $brand_id
     * @param $category_id
     * @param $gender
     * @return array|bool
     */
    public function actionGetProduct( AdminImportStageController $stage, $sku, $brand_id, $category_id, $gender )
    {
        $product = $this->actionFindProductBySku( $sku );

        if( isset( $product->id ) )
        {
            // make alert
            $stage->actionPushStage( 'WARNING', 'Данный sku уже был найден.' );

            // return that product is found
            return array(
                'found' => 1,
                'product_id' => $product->id,
            );
        } else
        {
            // create new product
            return $this->actionCreateProduct( $stage, $sku, $brand_id, $category_id, $gender );
        }
    }

    /**
     * Creation of new product
     * Includes generating of new public store id
     * as well as backend product id
     * If no errors found create with status 0
     * that item was justly created
     * @param AdminImportStageController $stage
     * @param $sku
     * @param $brand_id
     * @param $category_id
     * @param $gender
     * @return array|bool
     */
    private function actionCreateProduct( AdminImportStageController $stage, $sku, $brand_id, $category_id, $gender )
    {
        try
        {
            // trying generating hash for
            // public usages
            $public_store_id = $this->actionGetHash( '0777' );
        } catch( \Exception $e )
        {
            // make Error alert
            $stage->actionPushStage( 'ERROR', 'Проблема с генерированием публичного Id продукта.' );
        }

        try
        {
            // trying generating hash for
            // admin usages
            $product_backend_id = $this->actionGetHash( '2222' );
        } catch( \Exception $e )
        {
            // make Error alert
            $stage->actionPushStage( 'ERROR', 'Проблема с генерированием админского Id продукта.' );
        }

        $gender_id = $this->actionFindGender( $stage, $gender );
        $stock_id = $this->actionGetDefaultStockId();

        // if all hashes are generated normally
        if( isset( $public_store_id ) && isset( $product_backend_id ) )
        {
            try
            {
                // create new product
                ProductModel::create([
                    'sku' => $sku,
                    'product_store_id' => $public_store_id,
                    'product_backend_id' => $product_backend_id,
                    'brand_id' => $brand_id,
                    'category_id' => $category_id,
                    'dev_index_gender_id' => $gender_id,
                    'stock_id' => $stock_id,
                ]);

                // getting new product id
                // cannot use dependency injection
                // due to transaction process of MySQL
                $product = $this->actionFindProductBySku( $sku );

                // items was justly created
                return array(
                    'found' => 0,
                    'product_id' => $product->id,
                );
            } catch( \Exception $e )
            {
                // make Error alert
                $stage->actionNotForcePush( 'ERROR', 'Проблема с созданием сложенного продукта.' );
            }

            // return fail
            return false;
        } else
        {
            // return fail
            return false;
        }
    }

    /**
     * Getting first available stock
     * From shop stocks table
     * @return mixed
     */
    private function actionGetDefaultStockId()
    {
        $stock = ProductStockModel::orderBy('id')
            ->first(['id']);

        return $stock->id;
    }

    /**
     * Finding gender for product
     * If gender is found return id
     * Else make Error alert
     * @param AdminImportStageController $stage
     * @param $gender
     * @return bool
     */
    private function actionFindGender( AdminImportStageController $stage, $gender )
    {
        $gender = BasicGenderModel::where( 'name', 'LIKE', '%' . $gender . '%')
            ->first(['id']);

        if( !isset( $gender->id ) )
        {
            // make Error alert
            $stage->actionPushStage( 'ERROR', 'Гендер не найден: ' . $gender );
            return false;
        }

        return $gender->id;
    }

    /**
     * Getting update for parent sub product
     * Due to exchange SWITCH method for
     * Parties Handler method
     * @param $sub_product_id
     * @param $parent_id
     */
    public function actionUpdateParentForSubProduct( $sub_product_id, $parent_id )
    {
        $product = SubProductModel::findOrFail( $sub_product_id );

        // change parent id
        $product->dev_product_index_id = $parent_id;
        $product->save();
    }

    /**
     * Searching of a product with error reporting
     * By sku attribute
     * If found return id
     * else return Error message
     * @param AdminImportStageController $stage
     * @param $sku
     * @return bool
     */
    public function actionSearchProduct( AdminImportStageController $stage, $sku )
    {
        $product = ProductModel::where( 'sku', $sku )
            ->first(['id']);

        if( isset( $product->id ) )
        {
            return $product->id;
        } else
        {
            // make Error alert
            $stage->actionPushStage( 'ERROR', 'Продукт с данным sku: ' . $sku . ' не найден');
        }

        // return fail
        return false;
    }

    /**
     * Updating product attributes
     * for Updating import
     * If any field present make update
     * Else skip
     * @param $product_id
     * @param $update_product
     */
    public function actionUpdateProduct( $product_id, $update_product )
    {
        $updateArray = array();

        // getting fields to update
        foreach( $update_product as $row => $data )
        {
            if( $data != '' )
            {
                $updateArray[$row] = $data;
            }
        }

        // if not empty fields list
        if( !empty( $updateArray ) )
        {
            ProductModel::findOrFail( $product_id )
                ->update( $updateArray );
        }
    }

}