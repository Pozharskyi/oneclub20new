<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 05.10.2016
 * Time: 16:32
 */

namespace App\Http\Controllers\Admin\Import\Core;

trait AdminImportFileParserTrait
{
    /**
     * Getting CSV file
     * rows count
     * @param $filePath
     * @return int
     */
    public function actionCountCsv($filePath)
    {
        $file = array_map('str_getcsv', file($filePath));

        return count($file);
    }
}