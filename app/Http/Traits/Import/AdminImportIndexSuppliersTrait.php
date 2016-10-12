<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 14:22
 */

namespace App\Http\Controllers\Traits\Import;

use App\Models\Import\ImportIndexSuppliersModel;

trait AdminImportIndexSuppliersTrait
{
    public function actionGetAllSuppliers()
    {
        $suppliers = ImportIndexSuppliersModel::get(
            'id', 'name'
        );

        return $suppliers;
    }

}