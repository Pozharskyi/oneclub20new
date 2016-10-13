<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 14:10
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Controller;

class AdminImportUploadingCsvParserController extends Controller
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

    public static function actionCountCsv($import_file_path)
    {
        // getting parsed CSV to Array
        $data = self::actionParseCsvToArray($import_file_path);

        return count($data) + 1; // due to headers
    }
}