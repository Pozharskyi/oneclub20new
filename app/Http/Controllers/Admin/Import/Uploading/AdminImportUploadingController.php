<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 13:39
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminImportUploadingController extends Controller
{
    public function actionPrepareUpload(Request $request)
    {
        $input = $request->file('file');

        // SET UPLOAD PATH
        $destinationPath = 'uploads';

        // GET THE FILE EXTENSION
        $extension = $input->getClientOriginalExtension();

        if( $extension != 'csv' )
        {
            $message = 'Файл должен быть в формате CSV';
            return view('admin.import.alert_error', [
                'message' => $message,
            ]);
        }

        // RENAME THE UPLOAD WITH RANDOM NUMBER
        $fileName = date('Y-m-d') . 'V' . date('His') . '.' . $extension;

        // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
        $input->move($destinationPath, $fileName);

        $file = $destinationPath . '/' . $fileName;

        return 'true';
    }

}