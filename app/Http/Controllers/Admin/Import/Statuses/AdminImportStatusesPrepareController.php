<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 15:12
 */

namespace App\Http\Controllers\Admin\Import\Statuses;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportPartiesPrepareLogModel;
use App\Models\Import\ImportPartiesPrepareStatusesModel;

class AdminImportStatusesPrepareController extends Controller
{
    private $okStatus;

    public function __construct()
    {
        $this->okStatus = $this->actionFindStatusIdByPhrase('OK');
    }

    public final function actionFindStatusIdByPhrase( $phrase )
    {
        $status = ImportPartiesPrepareStatusesModel::findStatus( $phrase )
            ->first(['id']);

        return $status->id;
    }

    public final function actionLogPrepareStatus( $fileAllocation, $fileLine, $prepareStatus )
    {
        $logArray = array(
            'file_allocation_id' => $fileAllocation,
            'file_line' => $fileLine,
            'prepare_status_id' => $prepareStatus,
        );

        ImportPartiesPrepareLogModel::create( $logArray );
    }

    public final function actionValidateErrorsForAllocation( $fileAllocation )
    {
        $errors = ImportPartiesPrepareLogModel::filterByAllocationErrors( $fileAllocation, $this->okStatus )
            ->count();

        return $errors;
    }

    public final function actionGetErrorsByAllocation( $fileAllocation )
    {
        $errors = ImportPartiesPrepareLogModel::filterByAllocation( $fileAllocation )
            ->with(['prepareStatus'])
            ->get();

        $result = array();

        foreach($errors as $error)
        {
            if( !isset($result[$error->file_line]) )
            {
                $result[$error->file_line] = array();
            }

            $columnName = $error->prepareStatus->file_column_name;
            $result[$error->file_line][$columnName] = 'found';
        }

        return $result;
    }

}