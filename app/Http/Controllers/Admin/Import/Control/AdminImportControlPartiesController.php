<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 11:44
 */

namespace App\Http\Controllers\Admin\Import\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;

class AdminImportControlPartiesController extends AdminImportControlPartiesValidationController
{
    public function actionManageParties(Request $request)
    {
        $party_id = $request->input('party_id');
        $allocation = Allocation::actionGetAllocation($party_id);

        $file = $allocation->file;
        $allocationId = $allocation->allocationId;
        $supplierId = $allocation->supplierId;

        try
        {
            $this->actionValidateCoincidence( $allocationId, $file, $supplierId );
            $message = 'Пакетная обработка была успешно завершена.';

            return view('admin.import.control.alert_success', [
                'message' => $message,
            ]);
        } catch( \Exception $e )
        {
            $message = 'Что-то пошло не так. Попробуйте чуть позже.';

            return view('admin.import.control.alert_failed', [
                'message' => $message,
            ]);
        }
    }
}