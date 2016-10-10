<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:45
 */

namespace App\Http\Controllers\Admin\Manage\Brands;

use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\Basic\BasicBrandsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManageBrandsCreateController extends AdminManageBrandsValidationController implements AdminImportCreateInterface
{
    public function actionGetCreateView(Request $request)
    {
        return view('admin.manage.brands.create');
    }

    public function actionCreate(Request $request)
    {
        $brand_name = $request->input('brand_name');

        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $user_id = Auth::user()->id;
        }

        $existence = $this->actionValidateIfBrandExists($brand_name);

        if ($existence === false) {
            try {
                BasicBrandsModel::create([
                    'brand_name' => $brand_name,
                    'made_by' => $user_id,
                ]);

                return redirect('/admin/manage/brands?alert=created');

            } catch (\Exception $e) {
                return redirect('/admin/manage/brands?alert=failed');
            }
        } else {
            return redirect('/admin/manage/brands?alert=brand_exists');
        }
    }

}