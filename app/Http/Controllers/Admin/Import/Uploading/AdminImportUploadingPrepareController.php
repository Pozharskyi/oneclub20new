<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 0:31
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesPrepareController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;

class AdminImportUploadingPrepareController extends AdminImportUploadingPrepareValidationController
{
    private $prepareStatuses;

    public function __construct()
    {
        $this->prepareStatuses = new AdminImportStatusesPrepareController();
    }

    public function actionParse(Request $request)
    {
        $party_id = $request->input('party_id');
        $allocation = Allocation::actionGetAllocation($party_id);

        $file = $allocation->file;
        $allocationId = $allocation->allocationId;

        $validation = $this->actionValidateFile($file);

        if (!$validation['valid'])
        {
            Allocation::actionChangeAllocationStatus($allocationId, 'Файл не корретный');

            return view('admin.import.alert_error', [
                'message' => $validation['message'],
            ]);
        } else
        {
            $errors = $this->actionValidateFileRules( $this->prepareStatuses, $file, $allocationId );

            if( $errors > 0 )
            {
                Allocation::actionChangeAllocationStatus($allocationId, 'Найдены ошибки');

                return view('admin.import.uploading.prepare.alert_error', [
                    'message' => 'В файле импорта были обнаружены ошибки',
                    'allocationId' => $allocationId,
                ]);
            }

            Allocation::actionChangeAllocationStatus($allocationId, 'Готов к обработке');

            return view('admin.import.uploading.prepare.alert_success', [
                'message' => 'Файл импорта был успешно загружен',
                'party_id' => $party_id,
            ]);
        }
    }

}