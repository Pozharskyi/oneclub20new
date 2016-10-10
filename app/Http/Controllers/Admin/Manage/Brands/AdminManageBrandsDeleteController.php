<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin\Manage\Brands;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Basic\BasicBrandsModel;
use Illuminate\Http\Request;

class AdminManageBrandsDeleteController extends Controller implements AdminImportDeleteInterface
{
    public function actionDelete( Request $request )
    {
        $brand_id = $request->input( 'brand_id' );
        $result = 'true';

        try
        {
            $brand = BasicBrandsModel::findOrFail( $brand_id );
            $brand->delete();
        } catch( \Exception $e )
        {
            $result = 'false';
        }

        return $result;
    }

}