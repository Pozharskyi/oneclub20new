<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 10.10.2016
 * Time: 14:34
 */

namespace App\Http\Controllers\Admin\Departments\Photography;

use App\Http\Controllers\Admin\Departments\AdminDepartmentFatStatusTrait;
use App\Http\Controllers\Admin\Departments\AdminDepartmentPhotographyFileHandlerTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Departments\AdminDepartmentsEditInterface;
use DB;
use App\Models\Product\ProductPhotoModel;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

class AdminDepartmentPhotographyEditController extends Controller implements
    AdminDepartmentsEditInterface
{
    use AdminDepartmentPhotographyFileHandlerTrait;
    use AdminDepartmentFatStatusTrait;

    const MAX = 6;

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
                'photos',
            ])->findOrFail($subProduct);

            $i = 0;

            while ($i < self::MAX) {
                if (!isset($info->photos[$i])) {
                    $info->photos[$i] = new \stdClass();
                    $info->photos[$i]->photo = '#';
                }

                $i++;
            }

            return view('admin.departments.photography.edit', [
                'info' => $info,
                'fat_status' => $fatStatusForCheck,
                'max' => self::MAX,
            ]);
        } catch (\Exception $e) {
            return view('admin.departments.alerts', [
                'alert' => 'failed',
            ]);
        }
    }

    public function actionEdit(Request $request)
    {
        $subProductId = $request->input('subProductId');

        $i = 0;
        $max = self::MAX;

        $files = [];

        DB::beginTransaction();

        try {
            ProductPhotoModel::where('sub_product_id', $subProductId)
                ->delete();

            while ($i < $max) {
                $src = $request->input('src_' . $i);

                if ($src == 'changed') {
                    $file_path = $this->actionHandleFile($request, $i);
                    array_push($files, $file_path);
                } else {
                    $file_path = $request->input('oldSrc_' . $i);
                }

                if ($file_path != '' && $file_path != '#') {
                    ProductPhotoModel::create([
                        'sub_product_id' => $subProductId,
                        'photo' => $file_path,
                    ]);
                }

                $i++;
            }

            $this->actionHandleFatStatus($request);

            DB::commit();

            return redirect('/admin/departments/photography?alert=confirmed');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/departments/photography?alert=failed');
        }

    }

}