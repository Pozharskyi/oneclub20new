<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 21:27
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Import\ImportSalesShareModel;
use Illuminate\Http\Request;

/**
 * Deleting share based on info
 * Class AdminImportShareDeleteController
 * @package App\Http\Controllers\Admin\Import\Share
 */
class AdminImportShareDeleteController extends Controller implements AdminImportDeleteInterface
{
    /**
     * Deleting share based on id
     * If success make ok response
     * else make bad response
     * @param Request $request
     * @return string
     */
    public function actionDelete( Request $request )
    {
        $share_id = $request->input( 'share_id' );

        try
        {
            ImportSalesShareModel::findOrFail( $share_id )
                ->delete();

            return 'true';
        } catch ( \Exception $e )
        {
            return 'false';
        }
    }

}