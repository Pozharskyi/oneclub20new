<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 09.10.2016
 * Time: 14:09
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Http\Controllers\Admin\Import\Suppliers\AdminImportSuppliersCollectionController as Collection;
use App\Models\Supplier\SupplierModel;
use Illuminate\Http\Request;

class AdminImportSuppliersUpdateController extends Controller implements AdminImportUpdateInterface
{
    public function actionGetView( $supplierId, Request $request )
    {
        $info = SupplierModel::findOrFail($supplierId);
        $alert = $request->input('alert');

        if (!isset($alert)) {
            $alert = null;
        }

        $workStatuses = ['Работаем', 'Не работаем'];
        $agreementTypes = ['Есть', 'Нету'];

        return view('admin.import.suppliers.update', [
            'info' => $info,
            'supplier_id' => $supplierId,
            'workStatuses' => $workStatuses,
            'agreementTypes' => $agreementTypes,
            'alert' => $alert,
        ]);
    }

    public function actionUpdate(Request $request)
    {
        $collection = Collection::actionHandleRequest($request);
        $supplierId = $request->input('supplier_id');

        $redirectUri = '/admin/import/suppliers/update/' . $supplierId;

        try {
            SupplierModel::findOrFail($supplierId)
                ->update($collection);

            return redirect($redirectUri . '?alert=updated');
        } catch (\Exception $e) {
            return redirect($redirectUri . '?alert=failed');
        }
    }

}