<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.09.2016
 * Time: 16:36
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use App\Models\Import\ImportPartiesModel;
use Illuminate\Http\Request;

/**
 * Handler of parties deletion
 * Class AdminImportPartiesDeleteController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesDeleteController extends Controller implements AdminImportDeleteInterface
{
    /**
     * Deleting party based on request
     * By party identify
     * @param Request $request
     * @return string
     */
    public function actionDelete( Request $request )
    {
        // getting party identify
        $party_id = $request->input('party_id');

        try
        {
            // trying to delete party
            ImportPartiesModel::findOrFail( $party_id )
                ->delete();

            // if succeed return nice response
            return 'true';

        } catch ( \Exception $e )
        {
            // else return bad response
            return 'false';
        }
    }

}