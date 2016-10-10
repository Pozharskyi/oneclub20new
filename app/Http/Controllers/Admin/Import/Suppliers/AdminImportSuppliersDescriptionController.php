<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 09.10.2016
 * Time: 13:48
 */

namespace App\Http\Controllers\Admin\Import\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierModel;
use App\Http\Controllers\Admin\Import\Suppliers\AdminImportSuppliersCollectionController as Collection;

class AdminImportSuppliersDescriptionController extends Controller
{
    public function actionGetDescription($supplier_id)
    {
        $info = SupplierModel::findOrFail($supplier_id);

        $collection = Collection::actionGetAllocationsForSuppliers();
        $results = array();

        foreach ($collection as $tag => $category) {
            $results[$category] = $info->{$tag};
        }

        return view('admin.import.suppliers.description', [
            'results' => $results,
        ]);
    }
}