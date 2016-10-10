<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 16:14
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

/**
 * Getting SubProduct Deletion handler
 * Based on Request
 * Class AdminImportPartiesSubProductsDeleteController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesSubProductsDeleteController extends Controller implements AdminImportDeleteInterface
{
    /**
     * Handle to delete SubProduct
     * Based on Request
     * @param Request $request
     * @return string
     */
    public function actionDelete( Request $request )
    {
        // sub product
        $sub_product_id = $request->input('sub_product_id');

        try
        {
            // trying to delete ...
            SubProductModel::findOrFail( $sub_product_id )
                ->delete();

            // if success return ok response
            return 'true';
        } catch ( \Exception $e )
        {
            // if error return bad response
            return 'false';
        }
    }

}