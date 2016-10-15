<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 11:47
 */

namespace App\Http\Controllers\Admin\Import\Statuses;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportPartiesCoincidenceStatusesModel;

class AdminImportStatusesCoincidenceController extends Controller
{
    public final function actionFindStatusIdByPhrase( $phrase )
    {
        $status = ImportPartiesCoincidenceStatusesModel::findStatus( $phrase )
            ->first(['id']);

        return $status->id;
    }

}