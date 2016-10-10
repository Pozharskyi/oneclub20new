<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 12:26
 */

namespace App\Http\Controllers\Admin\Departments\Content;

use App\Http\Controllers\Admin\Departments\AdminDepartmentFatStatusTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Departments\AdminDepartmentsEditInterface;
use App\Models\Product\ProductDescriptionModel;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

class AdminDepartmentsContentEditController extends Controller implements
    AdminDepartmentsEditInterface
{
    use AdminDepartmentFatStatusTrait;

    protected $fields = [
        'product_name', 'product_description',
        'product_composition', 'comment_frontend',
        'country_manufacturer',
    ];

    public function actionGetEditView(Request $request)
    {
        $subProduct = $request->input('subProductId');
        $fatStatusForCheck = $this->fat->actionSearchStatusByPhrase('APPROVED');

        try {
            $info = SubProductModel::with([
               'product.description' => function ($query) {
                    $query->get([
                        'product_name', 'product_description',
                        'product_composition', 'comment_frontend',
                        'country_manufacturer',
                    ]);
               }
            ])->findOrFail($subProduct);

            return view('admin.departments.content.edit', [
                'info' => $info,
                'fat_status' => $fatStatusForCheck
            ]);
        } catch (\Exception $e) {
           return view('admin.departments.alerts', [
                'alert' => 'failed',
           ]);
        }
    }

    public function actionEdit(Request $request)
    {
        $parentProductId = $request->input('parentProductId');

        $updateFields = array();

        foreach ($this->fields as $field) {
            $updateFields[$field] = $request->input($field);
        }

        try {
            ProductDescriptionModel::findParent($parentProductId)
                ->update($updateFields);

            $this->actionHandleFatStatus($request);

            return 'success';
        } catch (\Exception $e) {
            return 'alert';
        }
    }
}