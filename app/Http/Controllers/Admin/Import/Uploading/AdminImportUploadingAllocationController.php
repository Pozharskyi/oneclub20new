<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 13:39
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesWorkController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Product\ProductCategoriesTrait;
use App\Models\Import\ImportPartiesFileAllocationModel;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingCsvParserController as CsvParser;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingPhotosFoundController as PhotoController;
use Illuminate\Http\Request;

class AdminImportUploadingAllocationController extends Controller
{
    use ProductCategoriesTrait;

    public static function actionGetAllocation( $party_id )
    {
        $allocation = ImportPartiesFileAllocationModel::filterParties($party_id)
            ->with(['parties'])
            ->orderBy('id' ,'DESC')
            ->first(['id', 'import_file_path', 'import_index_party_id']);

        $file = CsvParser::actionParseCsvToArray( $allocation->import_file_path );
        $allocationId = $allocation->id;

        $result = new \stdClass();
        $result->file = $file;
        $result->allocationId = $allocationId;
        $result->import_file_path = $allocation->import_file_path;
        $result->supplierId = $allocation->parties->import_supplier_id;

        return $result;
    }

    public static function actionUpdateAllocation( $allocationId, $fileLinesProcessed )
    {
        $allocation = ImportPartiesFileAllocationModel::find($allocationId);
        $allocation->file_lines_processed = $fileLinesProcessed + 1;

        $allocation->save();
    }

    public static function actionGetFileByAllocation( $allocationId )
    {
        $allocation = ImportPartiesFileAllocationModel::find($allocationId);

        return $allocation->import_file_path;
    }

    public static function actionGetAllocationPrepareLogs( $party_id )
    {
        $logs = ImportPartiesFileAllocationModel::filterParties($party_id)
            ->with(['madeBy', 'partiesPrepareLog'])
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();

        return $logs;
    }

    public static function actionGetPartyByAllocation( $allocationId )
    {
        $allocation = ImportPartiesFileAllocationModel::find( $allocationId );

        return $allocation->import_index_party_id;
    }

    public static function actionChangeAllocationStatusForDone( $allocationId )
    {
        $allocation = ImportPartiesFileAllocationModel::find( $allocationId );
        $allocation->allocation_status = 'Файл обработан';

        $allocation->save();
    }

    public static function actionChangeAllocationStatus( $allocationId, $allocationStatus )
    {
        $allocation = ImportPartiesFileAllocationModel::find($allocationId);
        $allocation->allocation_status = $allocationStatus;

        $allocation->save();
    }

    public function actionGetAllocationDescriptionByLine(Request $request)
    {
        $allocationId = $request->input('allocationId');
        $fileLine = $request->input('fileLine');

        $allocation = ImportPartiesFileAllocationModel::find($allocationId);
        $filePath = $allocation->import_file_path;

        $file = CsvParser::actionParseCsvToArray( $filePath );
        $data = $file[$fileLine];

        $photos = PhotoController::actionGetPhotosForProduct( $allocationId, $fileLine );
        $categories = $this->actionFindCategoryTreeByLast( $data['product_name'] );
        $data['cat1'] = $categories[0]['name'];
        $data['cat2'] = $categories[1]['name'];
        $data['cat3'] = $categories[2]['name'];

        $logs = AdminImportStatusesWorkController::actionGetLogsCountByParams( $allocationId, $fileLine );
        $categoryId = $this->actionSearchLastCategory( $data['product_name'] );

        return view('admin.import.uploading.allocation_row', [
            'data' => $data,
            'categoryId' => $categoryId,
            'fileLine' => $fileLine,

            'logs' => $logs,
            'photos' => $photos,
            'photos_count' => count( $photos ),
        ]);
    }
}