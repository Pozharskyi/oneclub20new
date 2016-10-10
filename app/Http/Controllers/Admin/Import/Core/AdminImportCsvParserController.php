<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 23.09.2016
 * Time: 12:31
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Core\AdminImportCsvParserInterface;

class AdminImportCsvParserController extends Controller implements AdminImportCsvParserInterface
{
    /**
     * Parse CSV array
     * @param string $filename
     * @param string $delimiter
     * @return array|bool
     */
    public static function actionParseCsvToArray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }

            fclose($handle);
        }

        return $data;
    }
}