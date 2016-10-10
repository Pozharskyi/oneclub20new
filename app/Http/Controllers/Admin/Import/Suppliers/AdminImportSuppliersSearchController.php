<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 16:28
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportSearchInterface;
use App\Models\Supplier\SupplierModel;
use Illuminate\Http\Request;

/**
 * Finding supplier
 * based on supplier name or any
 * Class AdminImportSuppliersFindController
 * @package App\Http\Controllers\Admin\Import\Suppliers
 */
class AdminImportSuppliersSearchController extends Controller implements AdminImportSearchInterface
{
    /**
     * Searching supplier by Request
     * If suppliers found return object
     * else return empty variable
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearch( Request $request )
    {
        $search = $request->input('search');

        $suppliers = SupplierModel::with(['user'])
            ->search( $search )
            ->get();

        if( count( $suppliers ) == 0 )
        {
            $suppliers = null;
        }

        return view('admin.import.suppliers.find', [
            'suppliers' => $suppliers,
        ]);
    }
}