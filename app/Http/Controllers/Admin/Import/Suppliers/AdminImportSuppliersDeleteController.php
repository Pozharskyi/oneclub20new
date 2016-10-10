<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 16:01
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportDeleteInterface;
use Illuminate\Http\Request;

use App\Models\Supplier\SupplierModel;

/**
 * Suppliers Deletion Handler
 * Class AdminImportSuppliersDeleteController
 * @package App\Http\Controllers\Admin\Import\Suppliers
 */
class AdminImportSuppliersDeleteController extends Controller implements AdminImportDeleteInterface
{
    /**
     * Deleting supplier based
     * on supplier id
     * @param Request $request
     * @return 0
     */
    public function actionDelete( Request $request )
    {
        $supplier_id = $request->input('supplier_id');

        SupplierModel::findOrFail( $supplier_id )
            ->delete();

        return 0;
    }

}