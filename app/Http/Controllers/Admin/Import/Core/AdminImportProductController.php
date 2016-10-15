<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.10.2016
 * Time: 0:25
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesWorkController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Basic\BasicBrandsTrait;
use App\Http\Controllers\Traits\Basic\BasicCodesTrait;
use App\Http\Controllers\Traits\Basic\BasicColorsTrait;
use App\Http\Controllers\Traits\Basic\BasicGenderTrait;
use App\Models\Product\ProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingCsvParserController as CsvParser;

class AdminImportProductController extends Controller
{
    use BasicCodesTrait;
    use BasicColorsTrait;
    use BasicBrandsTrait;
    use BasicGenderTrait;

    private $workStatus;
    private $message;

    public function __construct()
    {
        $this->workStatus = new AdminImportStatusesWorkController;
    }

    public final function actionHandleImport(Request $request)
    {
        try
        {
            $filePath = $request->input('filePath');

            $partyId = $request->input('partyId');
            $allocationId = $request->input('allocationId');
            $fileLine = $request->input('fileLine');

            $file = CsvParser::actionParseCsvToArray( $filePath );
            $data = $file[$fileLine];

            $pushArray = array(
                'sku' => $data['sku'],
                'product_store_id' => $this->actionGetHash('0777'),
                'product_backend_id' => $this->actionGetHash('6666'),
                'dev_product_color_id' => $this->actionFindColor( $data['color'] ),
                'brand_id' => $this->actionFindBrand( $data['brand'] ),
                'category_id' => $request->input('categoryId'),
                'dev_index_gender_id' => $this->actionFindGender( $data['gender'] ),
                'import_index_party_id' => $partyId,
            );

            $product = ProductModel::create( $pushArray );

            $tasks = $request->input('tasks');

            if( isset( $tasks ) && $tasks != '' )
            {
                foreach( $tasks as $task )
                {
                    $this->workStatus->actionLogWorkStatus($allocationId, $product->id, $fileLine, $task);
                }
            } else
            {
                $this->workStatus->actionLogWorkStatus(
                    $allocationId, $product->id,
                    $fileLine, $this->workStatus->approvedStatus
                );
            }

            $this->message = 'Успех';

        } catch( \Exception $e )
        {
            echo $e->getMessage();
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.core.product', [
            'message' => $this->message,
        ]);
    }

}