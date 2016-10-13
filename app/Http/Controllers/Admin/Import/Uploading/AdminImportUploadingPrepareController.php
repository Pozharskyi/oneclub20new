<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 0:31
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;

class AdminImportUploadingPrepareController extends AdminImportUploadingPrepareValidationController
{
    public function actionParse(Request $request)
    {
        $party_id = $request->input('party_id');
        $file = Allocation::actionGetFile($party_id);

        $validation = $this->actionValidateFile($file);

        if (!$validation['valid'])
        {
            return view('admin.import.alert_error', [
                'message' => $validation['message'],
            ]);
        } else
        {
            return view('admin.import.alert', [
                'message' => 'Файл успешно загружен',
            ]);
        }
    }

}