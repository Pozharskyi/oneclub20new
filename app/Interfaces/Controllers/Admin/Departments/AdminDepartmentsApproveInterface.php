<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 11:29
 */

namespace App\Interfaces\Controllers\Admin\Departments;

use Illuminate\Http\Request;

/**
 * Primary handler for products
 * based on department selection
 * Class AdminDepartmentsApproveInterface
 * @package App\Interfaces\Controllers\Admin\Departments
 */
interface AdminDepartmentsApproveInterface
{
    /**
     * Handler for approving products
     * based on category selected
     * @param Request $request
     */
    public function actionApproveProduct(Request $request);

}