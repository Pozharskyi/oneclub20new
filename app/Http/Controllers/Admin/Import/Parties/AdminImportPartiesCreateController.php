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
use App\Http\Controllers\Traits\Import\AdminImportIndexCategoriesTrait;
use App\Http\Controllers\Traits\Import\AdminImportIndexSuppliersTrait;
use App\Http\Requests\Request;
use App\Interfaces\Controllers\Import\AdminImportCreateInterface;

class AdminImportPartiesCreateController extends Controller implements AdminImportCreateInterface
{
    use AdminImportIndexSuppliersTrait;
    use AdminImportIndexCategoriesTrait;

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

    }
}