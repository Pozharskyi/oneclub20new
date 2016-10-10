<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 11:49
 */

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportLogPartiesProcessModel as ProcessLog;

abstract class AdminDepartmentsFatStatusController extends Controller
{
    protected $fat;

    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController;
    }

    protected function actionFindProductByFatStatus($fatStatus)
    {
        $products = ProcessLog::exactStatus($fatStatus)
            ->with([
                'subProduct', 'subProduct.photos',
                'subProduct.size', 'subProduct.product',
            ])
            ->get(['sub_product_id', 'message']);

        return $products;
    }

    abstract public function actionGetStatusForCategory();

}