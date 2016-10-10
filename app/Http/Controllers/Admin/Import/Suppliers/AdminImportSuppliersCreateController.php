<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 13:59
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Http\Controllers\Admin\Import\Suppliers\AdminImportSuppliersCollectionController as Collection;
use App\Models\Supplier\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handler for creation of suppliers
 * Getting view with handler
 * Class AdminImportSuppliersCreateController
 * @package App\Http\Controllers\Admin\Import\Suppliers
 */
class AdminImportSuppliersCreateController extends Controller implements AdminImportCreateInterface
{
    /**
     * Getting for suppliers
     * create View
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetCreateView( Request $request )
    {
        $workStatuses = ['Работаем', 'Не работаем'];
        $agreementTypes = ['Есть', 'Нету'];

        // getting view
        return view('admin.import.suppliers.create', [
            'workStatuses' => $workStatuses,
            'agreementTypes' => $agreementTypes,
        ]);
    }

    /**
     * Handler for creation of supplier
     * based on Request
     * if no user Auth return redirect
     * else create supplier
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionCreate(Request $request)
    {
        /**
         * Validate if request
         * is unique
         */
        $this->validate($request, [
            'name' => 'required|unique:dev_supplier|max:255',
        ]);

        $fields = Collection::actionHandleRequest($request);

        // if no user auth
        if( Auth::guest() )
        {
            // make redirect for login page
            return redirect('/login');
        } else
        {
            $made_by = Auth::user()->id;
        }

        $fields['made_by'] = $made_by;

        // create new supplier
        SupplierModel::create($fields);

        // return redirect
        return redirect('/admin/import/suppliers');

    }

}