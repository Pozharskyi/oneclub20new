<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:09
 */

namespace App\Interfaces\Controllers\Admin\Import\Core;

/**
 * Main Csv Parser Interface
 * Realizes Parsing CSV to Array
 * Interface AdminImportCsvParserInterface
 * @package App\Interfaces\Controllers\Admin\Import\Core
 */
interface AdminImportCsvParserInterface
{
    public static function actionParseCsvToArray( $file_name = '', $delimiter = ';' );

}