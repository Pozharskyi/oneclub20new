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
    public static function actionGetFile( $party_id )
    {
        $allocation = ImportPartiesFileAllocationModel::filterParties($party_id)
            ->orderBy('id' ,'DESC')
            ->first(['import_file_path']);

        $file = CsvParser::actionParseCsvToArray( $allocation->import_file_path );

        return $file;
    }
}