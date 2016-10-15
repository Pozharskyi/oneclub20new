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
use App\Models\Import\ImportPartiesCoincidenceLogModel;
use App\Models\Import\ImportPartiesCoincidenceStatusesModel;

class AdminImportStatusesCoincidenceController extends Controller
{
    public final function actionFindStatusIdByPhrase( $phrase )
    {
        $status = ImportPartiesCoincidenceStatusesModel::findStatus( $phrase )
            ->first(['id']);

        return $status->id;
    }

    public final function actionLogCoincidenceStatus( $fileAllocation, $fileLine, $coincidenceStatus )
    {
        $logArray = array(
            'file_allocation_id' => $fileAllocation,
            'file_line' => $fileLine,
            'coincidence_status_id' => $coincidenceStatus,
        );

        ImportPartiesCoincidenceLogModel::create( $logArray );
    }

    public static final function actionGetLogsForAllocation( $allocationId )
    {
        $logs = ImportPartiesCoincidenceLogModel::filterByAllocation($allocationId)
            ->with(['coincidenceStatus'])
            ->get(['file_line', 'coincidence_status_id']);

        return $logs;
    }

}