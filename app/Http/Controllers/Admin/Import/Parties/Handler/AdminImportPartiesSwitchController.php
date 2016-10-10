<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 22:11
 */

namespace App\Http\Controllers\Admin\Import\Parties\Handler;

use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesHandleInterface;
use DB;
use App\Http\Controllers\Admin\Import\Core\AdminImportLogTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportPhotosTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportPricesTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportProductColorsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportProductsTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportSupplierTrait;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesFatStatusController;
use App\Models\Import\ImportLogPartiesProcessModel;
use Illuminate\Http\Request;

/**
 * Handler for switch one product information
 * with another product
 * Includes updating of prices, parent_id
 * Includes searching for sub product in logs
 * Class AdminImportPartiesSwitchController
 * @package App\Http\Controllers\Admin\Import\Parties\Handler
 */
class AdminImportPartiesSwitchController extends AdminImportPartiesFatStatusController implements
    AdminImportPartiesHandleInterface
{
    use AdminImportProductsTrait;
    use AdminImportProductColorsTrait;
    use AdminImportLogTrait;
    use AdminImportSupplierTrait;
    use AdminImportPricesTrait;
    use AdminImportPhotosTrait;

    /**
     * Handling switching one
     * product with another
     * Includes error reporting
     * @param Request $request
     * @return bool
     */
    public function actionHandleProduct( Request $request )
    {
        $party_id = $request->input('party_id');
        $file_line = $request->input('file_line');
        $fat_status_id = $request->input('fat_status_id');

        // search parent sub product
        $real_sub_product = $this->actionSearchSubProductForSwitch( $party_id, $file_line, $fat_status_id );

        // getting supplier identity
        $supplier_id = $this->actionSearchSupplierByParty( $party_id );

        $sku = $request->input('sku');
        $barcode = $request->input('barcode');
        $color = $request->input('color');

        // getting product by sku
        $product = $this->actionFindProductBySku( $sku );
        $product_id = $product->id;

        // getting color by name
        $color_id = $this->actionFindColorByName( $color );

        // logging sub product
        $info = $this->actionLogSubProduct( $product_id, $color_id, $barcode, $supplier_id);
        $sub_product_id = $info->sub_product_id;

        // getting prices for sub product
        $prices = $this->actionSearchProductPrices( $sub_product_id );

        // begin sql transaction
        DB::beginTransaction();

        try
        {
            // update parent id from another one
            $this->actionUpdateParentForSubProduct( $real_sub_product, $product_id );

            // update prices from first sub product to new one
            $this->actionUpdatePrices( $real_sub_product, $prices );

            // collecting photos from one sub product to another
            // with softDelete
            $this->actionUpdateProductPhotos( $real_sub_product, null, $sub_product_id );

            // restrict new status as SWITCHED
            $new_status = $this->fat->actionSearchStatusByPhrase( 'SWITCHED' );

            // log import parties line
            ImportLogPartiesProcessModel::confirmationUpdate( $party_id, $file_line, $fat_status_id )
                ->update([
                    'fat_status_id' => $new_status,
                    'message' => 'Заменен на: <a target="_blank" href="' . $info->uri . '"></a>',
                    'sub_product_id' => $real_sub_product,
                ]);

            // if succeed commit
            DB::commit();

            return true;
        } catch( \Exception $e )
        {
            // else deny transaction
            DB::rollBack();
            return false;
        }
    }

    /**
     * Updating prices and
     * collecting them from old one
     * For a new sub product
     * @param $sub_product_id
     * @param $prices
     */
    public function actionUpdatePrices( $sub_product_id, $prices )
    {
        // array to update
        $update = [
            'index_price' => $prices->index_price,
            'retail_price' => $prices->retail_price,
            'final_price' => $prices->final_price,
            'special_price' => $prices->special_price,
            'sale_percent' => $prices->sale_percent,
            'product_marga' => $prices->product_marga,
        ];

        // update sub product prices from another one
        $this->actionUpdateSubProductPrices($sub_product_id, $update);
    }

    /**
     * Searching sub product in logs
     * based on party, line, fat_status identify
     * Return matches
     * @param $partyId
     * @param $fileLine
     * @param $fatStatusId
     * @return mixed
     */
    public function actionSearchSubProductForSwitch($partyId, $fileLine, $fatStatusId)
    {
        $fat = ImportLogPartiesProcessModel::confirmationUpdate($partyId, $fileLine, $fatStatusId)
            ->first(['sub_product_id']);

        return $fat->sub_product_id;
    }

}