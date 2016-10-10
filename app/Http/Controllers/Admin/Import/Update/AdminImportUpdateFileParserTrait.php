<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 05.10.2016
 * Time: 17:36
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Admin\Import\Core\AdminImportCsvParserController as CsvParser;
use App\Models\Import\ImportUpdateProcessModel;

trait AdminImportUpdateFileParserTrait
{
    /**
     * Getting CSV file to parse
     * For Update Import
     * @param $updateId
     * @return array|bool
     */
    protected function actionGetCsvFile($updateId)
    {
        // getting file path
        $path = ImportUpdateProcessModel::where('update_id', $updateId)
            ->first(['file_base_path']);

        // getting csv to array
        $data = CsvParser::actionParseCsvToArray($path->file_base_path);

        return $data;
    }

    /**
     * Getting file description
     * For update import identity
     * with file line
     * @param $updateId
     * @param $fileLine
     * @return mixed
     */
    protected function actionGetFileDescription($updateId, $fileLine)
    {
        // getting csv file
        $file = $this->actionGetCsvFile($updateId);

        // control with any line
        $data = $file[$fileLine];

        return $data;
    }

}