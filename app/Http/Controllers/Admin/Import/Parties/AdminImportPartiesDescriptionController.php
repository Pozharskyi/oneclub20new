<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 19:28
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesCoincidenceController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;

class AdminImportPartiesDescriptionController extends Controller
{
    public function actionGetDescription(Request $request)
    {
        $party_id = $request->input('party_id');

        $allocation = Allocation::actionGetAllocation($party_id);
        $rows = $allocation->file;
        $count = count( $rows );

        $allocationId = $allocation->allocationId;
        $filePath = $allocation->import_file_path;

        $logs = AdminImportStatusesCoincidenceController::actionGetLogsForAllocation($allocationId);

        if( count($logs) != 0 )
        {
            foreach( $logs as $log )
            {
                $rows[$log->file_line]['validationColor'] = $log->coincidenceStatus->import_color;
            }

            $view = 'admin.import.parties.description_valid';

        } else
        {
            $view = 'admin.import.parties.description';
        }

        return view($view, [
            'rows' => $rows,
            'count' => $count,

            'party_id' => $party_id,
            'allocationId' => $allocationId,
            'filePath' => $filePath,
        ]);
    }

}