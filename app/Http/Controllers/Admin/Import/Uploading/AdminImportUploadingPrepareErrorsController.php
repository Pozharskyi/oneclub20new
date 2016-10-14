<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 16:50
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesPrepareController as PrepareController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingCsvParserController as CsvParser;

class AdminImportUploadingPrepareErrorsController extends Controller
{
    private $prepareStatuses;

    public function __construct()
    {
        $this->prepareStatuses = new PrepareController;
    }

    public function actionGetErrorsFile(Request $request)
    {
        $allocationId = $request->input('allocationId');

        $file = Allocation::actionGetFileByAllocation($allocationId);

        $fileArray = CsvParser::actionParseCsvToArray($file);
        $errors = $this->prepareStatuses->actionGetErrorsByAllocation( $allocationId );
        $headers = CsvParser::actionGetFileHeaders($fileArray);

        return view('admin.import.uploading.prepare.csv_errors', [
            'file' => $fileArray,
            'count' => count($fileArray),

            'errors' => $errors,
            'headers' => $headers,
        ]);
    }

}