<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 11:25
 */

namespace App\Interfaces\Controllers\Admin\Departments;
use Illuminate\Http\Request;

/**
 * Primary interface for interpretation
 * departments view
 * Interface AdminDepartmentsInterface
 * @package App\Interfaces\Controllers\Admin\Departments
 */
interface AdminDepartmentsInterface
{
    /**
     * Getting primary view
     * to select for edit
     * @return mixed
     */
    public function actionGetView(Request $request);
}