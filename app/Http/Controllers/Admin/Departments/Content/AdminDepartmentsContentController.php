<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 11:32
 */

namespace App\Http\Controllers\Admin\Departments\Content;

use App\Http\Controllers\Admin\Departments\AdminDepartmentsFatStatusController;
use App\Interfaces\Controllers\Admin\Departments\AdminDepartmentsInterface;
use Illuminate\Http\Request;

class AdminDepartmentsContentController extends AdminDepartmentsFatStatusController implements
    AdminDepartmentsInterface
{
    public function actionGetView(Request $request)
    {
        $alert = $request->input('alert');

        if (!isset($alert)) {
            $alert = null;
        }

        $fatStatus = $this->actionGetStatusForCategory();
        $products = $this->actionFindProductByFatStatus($fatStatus);
        $count = count($products);

        return view('admin.departments.content.index', [
            'alert' => $alert,
            'products' => $products,
            'count' => $count,
        ]);
    }

    public function actionGetStatusForCategory()
    {
        $fatStatus = $this->fat->actionSearchStatusByPhrase('CONTENT');

        return $fatStatus;
    }

}