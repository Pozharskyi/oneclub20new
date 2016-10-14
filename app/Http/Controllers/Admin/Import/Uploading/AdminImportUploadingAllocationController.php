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
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingCsvParserController as CsvParser;

class AdminImportUploadingAllocationController extends Controller
{
    public static function actionGetAllocation( $party_id )
    {
        $allocation = ImportPartiesFileAllocationModel::filterParties($party_id)
            ->orderBy('id' ,'DESC')
            ->first(['id', 'import_file_path']);

        $file = CsvParser::actionParseCsvToArray( $allocation->import_file_path );
        $allocationId = $allocation->id;

        $result = new \stdClass();
        $result->file = $file;
        $result->allocationId = $allocationId;

        return $result;
    }

    public static function actionUpdateAllocation( $allocationId, $fileLinesProcessed )
    {
        $allocation = ImportPartiesFileAllocationModel::find($allocationId);
        $allocation->file_lines_processed = $fileLinesProcessed;

        $allocation->save();
    }

    public static function actionGetFileByAllocation( $allocationId )
    {
        $allocation = ImportPartiesFileAllocationModel::find($allocationId);

        return $allocation->import_file_path;
    }
}