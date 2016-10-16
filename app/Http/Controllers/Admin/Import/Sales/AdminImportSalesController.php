<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 1:37
 */

namespace App\Http\Controllers\Admin\Import\Sales;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexSalesModel;

class AdminImportSalesController extends Controller
{
    public function actionGetAllSales()
    {
        $sales = ImportIndexSalesModel::get();

        return $sales;
    }

    public function actionGetInformationAboutSale( $sale_id )
    {
        $sale = ImportIndexSalesModel::findOrFail( $sale_id );

        return $sale;
    }

}