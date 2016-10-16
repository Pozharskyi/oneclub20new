<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 23:05
 */

namespace App\Http\Controllers\Admin\Import\Sales;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexSalesModel;
use App\Models\Import\ImportSalesLogDeleteModel;
use Illuminate\Http\Request;

class AdminImportSalesDeleteController extends Controller
{
    private $message;

    public function actionGetViewForDelete(Request $request)
    {
        $sale_id = $request->input('sale_id');

        $sale = ImportIndexSalesModel::findOrFail($sale_id);

        return view('admin.import.sales.delete', [
            'sale' => $sale,
        ]);
    }

    public function actionDelete(Request $request)
    {
        try
        {
            $party_id = $request->input('import_index_sale_id');
            $comment = $request->input('comment');

            ImportSalesLogDeleteModel::create([
                'import_index_sale_id' => $party_id,
                'comment' => $comment,
                'made_by' => \Auth::user()->id,
            ]);

            $this->message = 'Заявка на удаление была подана.';

        } catch( \Exception $e )
        {
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.alert', [
            'message' => $this->message,
        ]);
    }
}