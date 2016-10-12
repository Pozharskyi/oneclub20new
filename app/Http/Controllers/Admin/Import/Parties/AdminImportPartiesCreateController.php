<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 14:14
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Import\AdminImportDaysControlTrait;
use App\Http\Controllers\Traits\Import\AdminImportIndexCategoriesTrait;
use App\Http\Controllers\Traits\Import\AdminImportIndexSuppliersTrait;
use App\Http\Controllers\Traits\Import\AdminImportRedirectTrait;
use App\Models\Import\ImportIndexPartiesModel;
use Illuminate\Http\Request;
use App\Interfaces\Controllers\Import\AdminImportCreateInterface;
use Illuminate\Support\Facades\Auth;

class AdminImportPartiesCreateController extends Controller implements AdminImportCreateInterface
{
    use AdminImportIndexSuppliersTrait;
    use AdminImportIndexCategoriesTrait;
    use AdminImportDaysControlTrait;

    protected $fields = array(
        'party_name', 'import_supplier_id',
        'buyer_id', 'support_id',
        'party_start_date', 'party_end_date',
        'import_index_categories_id',
    );

    private $message;
    private $partiesStatus;

    public function __construct()
    {
        $this->partiesStatus = new AdminImportPartiesStatusController;
    }

    public function actionGetViewForCreate(Request $request)
    {
        $suppliers = $this->actionGetAllSuppliers();
        $categories = $this->actionGetImportCategories();

        return view('admin.import.parties.create', [
            'suppliers' => $suppliers,
            'categories' => $categories,
        ]);
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

            $fields['made_by'] = Auth::user()->id;
            $fields['party_days_count'] = $this->actionCountDaysBetweenDate(
                $fields['party_end_date'], $fields['party_start_date']
            );
            $fields['import_parties_status_id'] = $this->partiesStatus->actionGetStatusIdByPhrase('NEW');

            ImportIndexPartiesModel::create( $fields );
            $this->message = 'Вы успешно создали товарную партию';

        } catch( \Exception $e )
        {
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.parties.createResult', [
            'message' => $this->message,
        ]);
    }
}