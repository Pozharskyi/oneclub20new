<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 11:27
 */

namespace App\Interfaces\Controllers\Admin\Departments;

use Illuminate\Http\Request;

/**
 * Primary interface for getting view
 * and edit with two selections
 * Approve product or send for another department
 * Interface AdminDepartmentsEditInterface
 * @package App\Interfaces\Controllers\Admin\Departments
 */
interface AdminDepartmentsEditInterface
{
    /**
     * Getting all information
     * About product about category
     * @param Request $request
     * @return mixed
     */
    public function actionGetEditView(Request $request);

    /**
     * Editing an product
     * based on category
     * @param Request $request
     * @return mixed
     */
    public function actionEdit(Request $request);

}