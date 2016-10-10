<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 12:18
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\Supplier\SupplierModel;
use Illuminate\Http\Request;

/**
 * Getting suppliers View
 * in order to handle them
 * Class AdminImportSuppliersReadController
 * @package App\Http\Controllers\Admin\Import\Suppliers
 */
class AdminImportSuppliersReadController extends Controller implements AdminImportReadInterface
{
    /**
     * Getting suppliers index
     * View with persons
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionRead(Request $request)
    {
        $suppliers = SupplierModel::with(['user', 'buyer'])
            ->get();

        return view('admin.import.suppliers.read', [
            'suppliers' => $suppliers,
        ]);
    }

}