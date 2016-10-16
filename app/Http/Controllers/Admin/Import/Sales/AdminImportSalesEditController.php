<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 22:39
 */

namespace App\Http\Controllers\Admin\Import\Sales;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexSalesModel;
use App\Models\Import\ImportSalesLogEditModel;
use Illuminate\Http\Request;

class AdminImportSalesEditController extends Controller
{
    private $message;

    protected $fields = [
        'sale_name', 'sale_start_date',
        'sale_end_date', 'buyer_id',
    ];

    public function actionGetViewForEdit(Request $request)
    {
        $sale_id = $request->input('sale_id');

        $sale = ImportIndexSalesModel::with([
            'buyer'
        ])->findOrFail($sale_id);

        return view('admin.import.sales.edit', [
            'sale' => $sale,
        ]);
    }

    public function actionEdit(Request $request)
    {
        $edited = array();
        $updated = array();

        $sale_id = $request->input('sale_id');

        foreach( $this->fields as $field )
        {
            $oldValue = $request->input('old_' . $field);
            $newValue = $request->input($field);

            $now = date('Y-m-d H:i:s');

            if( $oldValue != $newValue )
            {
                $edited[] = array(
                    'import_index_sale_id' => $sale_id,
                    'field_changed' => $request->input('frontend_' . $field),
                    'field_current_value' => $newValue,
                    'field_changed_value' => $oldValue,
                    'made_by' => \Auth::user()->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                );

                $updated[$field] = $newValue;
            }
        }

        try
        {
            ImportSalesLogEditModel::insert($edited);
            ImportIndexSalesModel::findOrFail($sale_id)
                ->update($updated);

            $this->message = 'Вы успешно обновили товарную акцию';
        } catch(\Exception $e)
        {
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.alert', [
            'message' => $this->message,
        ]);
    }
}