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
use App\Models\Import\ImportPartiesFileAllocationModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingCsvParserController as CsvParser;

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
        } else
        {
            try
            {
                // RENAME THE UPLOAD WITH RANDOM NUMBER
                $fileName = date('Y-m-d') . 'V' . date('His') . '.' . $extension;

                // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
                $input->move($destinationPath, $fileName);
                $import_file_path = $destinationPath . '/' . $fileName;

                $allocation = array(
                    'import_index_party_id' => $request->input('party_id'),
                    'import_file_path' => $import_file_path,
                    'file_lines_processed' => 0,
                    'file_lines_total' => $this->actionCountCsv($import_file_path),
                    'made_by' => \Auth::user()->id,
                );

                ImportPartiesFileAllocationModel::create( $allocation );

                return 'true';
            } catch( \Exception $e )
            {
                $message = 'Что-то пошло не так. Попробуйте чуть позже.';
            }
        }

        return view('admin.import.alert_error', [
            'message' => $message,
        ]);
    }

    public function actionCountCsv($import_file_path)
    {
        // getting parsed CSV to Array
        $data = CsvParser::actionParseCsvToArray($import_file_path);

        return count($data) + 1; // due to headers
    }
}