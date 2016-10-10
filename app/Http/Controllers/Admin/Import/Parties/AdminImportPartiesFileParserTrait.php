<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 05.10.2016
 * Time: 17:47
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportCsvParserController as CsvParser;
use App\Models\Import\ImportPartiesProcessModel;

trait AdminImportPartiesFileParserTrait
{
    /**
     * Getting Csv file
     * convert CSV to Array
     * @param $partyId
     * @return array|bool
     */
    public function actionGetCsvFile($partyId)
    {
        // getting file path
        $path = ImportPartiesProcessModel::where('party_id', $partyId)
            ->first(['file_base_path']);

        // getting parsed CSV to Array
        $data = CsvParser::actionParseCsvToArray($path->file_base_path);

        return $data;
    }

    /**
     * Getting file description
     * Based on party file
     * And file row
     * @param $party_id
     * @param $file_line
     * @return mixed
     */
    public function actionGetFileDescription( $party_id, $file_line )
    {
        $file = $this->actionGetCsvFile( $party_id );
        $data = $file[$file_line];

        return $data;
    }

}