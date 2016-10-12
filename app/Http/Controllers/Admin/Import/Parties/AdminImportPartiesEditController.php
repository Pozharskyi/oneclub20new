<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 18:27
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Import\AdminImportIndexCategoriesTrait;
use App\Http\Controllers\Traits\Import\AdminImportIndexSuppliersTrait;
use App\Models\Import\ImportIndexPartiesModel;
use App\Models\Import\ImportPartiesLogEditModel;
use Illuminate\Http\Request;

class AdminImportPartiesEditController extends Controller
{
    use AdminImportIndexSuppliersTrait;
    use AdminImportIndexCategoriesTrait;

    private $message;

    protected $fields = array(
        'party_name', 'import_supplier_id',
        'buyer_id', 'support_id',
        'party_start_date', 'party_end_date',
        'import_index_categories_id',
    );

    public function actionGetViewForEdit(Request $request)
    {
        $party_id = $request->input('party_id');
        $suppliers = $this->actionGetAllSuppliers();
        $categories = $this->actionGetImportCategories();

        $party = ImportIndexPartiesModel::with([
            'buyer', 'supplier'
        ])->findOrFail($party_id);

        return view('admin.import.parties.edit', [
            'party' => $party,
            'suppliers' => $suppliers,
            'categories' => $categories,
        ]);
    }

    public function actionEdit(Request $request)
    {
        $edited = array();
        $updated = array();

        $party_id = $request->input('party_id');

        foreach( $this->fields as $field )
        {
            $oldValue = $request->input('old_' . $field);
            $newValue = $request->input($field);

            $now = date('Y-m-d H:i:s');

            if( $oldValue != $newValue )
            {
                $edited[] = array(
                    'import_index_party_id' => $party_id,
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
            ImportPartiesLogEditModel::insert($edited);
            ImportIndexPartiesModel::findOrFail($party_id)
                ->update($updated);

            $this->message = 'Вы успешно обновили товарную партию';
        } catch(\Exception $e)
        {
            $this->message = 'Что-то пошло не так. Попробуйте чуть позже.';
        }

        return view('admin.import.alert', [
            'message' => $this->message,
        ]);
    }

}