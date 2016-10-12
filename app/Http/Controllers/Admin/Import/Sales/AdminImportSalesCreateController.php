<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 22:15
 */

namespace App\Http\Controllers\Admin\Import\Sales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Import\AdminImportDaysControlTrait;
use App\Interfaces\Controllers\Import\AdminImportCreateInterface;
use App\Models\Import\ImportIndexSalesModel;
use Illuminate\Http\Request;

class AdminImportSalesCreateController extends Controller implements AdminImportCreateInterface
{
    use AdminImportDaysControlTrait;

    protected $fields = [
        'sale_name', 'sale_start_date',
        'sale_end_date', 'buyer_id',
    ];

    private $message;

    public function actionGetViewForCreate(Request $request)
    {
        return view('admin.import.sales.create');
    }

    public function actionCreate(Request $request)
    {
        $fields = array();

        try
        {
            foreach( $this->fields as $field )
            {
                $row = $request->input($field);
                $fields[$field] = $row;
            }

            $fields['made_by'] = \Auth::user()->id;
            $fields['sale_days_count'] = $this->actionCountDaysBetweenDate(
                $fields['sale_end_date'], $fields['sale_start_date']
            );

            ImportIndexSalesModel::create( $fields );
            $this->message = 'Вы успешно создали товарную акцию';

        } catch( \Exception $e )
        {
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.alert', [
            'message' => $this->message,
        ]);
    }

}