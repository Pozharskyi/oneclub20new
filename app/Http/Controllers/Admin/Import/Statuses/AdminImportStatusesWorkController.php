<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.10.2016
 * Time: 0:39
 */

namespace App\Http\Controllers\Admin\Import\Statuses;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportPartiesWorkLogModel;
use App\Models\Import\ImportPartiesWorkStatusesModel;

class AdminImportStatusesWorkController extends Controller
{
    public $approvedStatus;

    public function __construct()
    {
        $this->approvedStatus = $this->actionFindStatusIdByPhrase( 'APPROVED' );
    }

    public final function actionFindStatusIdByPhrase( $phrase )
    {
        $status = ImportPartiesWorkStatusesModel::findStatus( $phrase )
            ->first(['id']);

        return $status->id;
    }

    public static final function actionGetLogsForAllocation( $allocationId )
    {
        $logs = ImportPartiesWorkLogModel::filterByAllocation($allocationId)
            ->get(['file_line']);

        return $logs;
    }

    public static final function actionGetLogsCountByParams( $allocationId, $fileLine )
    {
        $logs = ImportPartiesWorkLogModel::filterByParams( $allocationId, $fileLine )
            ->count();

        return $logs;
    }

    public final function actionLogWorkStatus( $fileAllocation, $productId, $fileLine, $workStatus )
    {
        $logArray = array(
            'file_allocation_id' => $fileAllocation,
            'dev_product_index_id' => $productId,
            'file_line' => $fileLine,
            'work_status_id' => $workStatus,
        );

        ImportPartiesWorkLogModel::create( $logArray );
    }

}