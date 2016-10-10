<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:45
 */

namespace App\Http\Controllers\Admin\Manage\Sizes;

use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductSizeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManageSizesCreateController extends AdminManageSizesValidationController implements AdminImportCreateInterface
{
    public function actionGetCreateView( Request $request )
    {
        return view( 'admin.manage.sizes.create' );
    }

    public function actionCreate( Request $request )
    {
        $size_name = $request->input( 'size_name' );

        if( Auth::guest() )
        {
            return redirect( '/login' );
        } else
        {
            $user_id = Auth::user()->id;
        }

        $existence = $this->actionValidateIfSizeExists( $size_name );

        if( $existence === false )
        {
            try
            {
                ProductSizeModel::create([
                    'name' => $size_name,
                    'made_by' => $user_id,
                ]);

                return redirect('/admin/manage/sizes?alert=created');

            } catch (\Exception $e)
            {
                return redirect('/admin/manage/sizes?alert=failed');
            }
        } else
        {
            return redirect( '/admin/manage/sizes?alert=size_exists' );
        }
    }

}