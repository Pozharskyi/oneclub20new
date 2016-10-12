<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 13:31
 */

namespace App\Http\Controllers\Admin\Import\Sales;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Import\AdminImportReadInterface;
use App\Models\Import\ImportIndexSalesModel;

class AdminImportSalesReadController extends Controller implements AdminImportReadInterface
{
    public function actionGetViewForRead( $buyer_id = null )
    {
        $sales = ImportIndexSalesModel::with(['buyer'])
            ->get();

        return view( 'admin.import.sales.read', [
            'sales' => $sales,
            'count' => count( $sales ),
        ]);
    }

}