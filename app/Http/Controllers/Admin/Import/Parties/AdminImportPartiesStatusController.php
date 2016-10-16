<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 16:03
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportPartiesStatusesModel;

class AdminImportPartiesStatusController extends Controller
{
    public function actionGetStatusIdByPhrase( $phrase )
    {
        $status = ImportPartiesStatusesModel::findStatus( $phrase )
            ->first(['id']);

        return $status->id;
    }

}