<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 27.09.2016
 * Time: 17:04
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Controller;

use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Import\ImportUpdateModel;
use Illuminate\Http\Request;

/**
 * Deleting Import Parties Update
 * by update id identity
 * Class AdminImportUpdateDeleteController
 * @package App\Http\Controllers\Admin\Import\Update
 */
class AdminImportUpdateDeleteController extends Controller implements AdminImportDeleteInterface
{
    /**
     * Deleting import update
     * by requested id
     * @param Request $request
     * @return string
     */
    public function actionDelete( Request $request )
    {
        $update_id = $request->input('update_id');

        try
        {
            ImportUpdateModel::findOrFail( $update_id )
                ->delete();

            // if succeed
            return 'true';

        } catch( \Exception $e )
        {
            // if not succeed
            return 'false';
        }
    }

}