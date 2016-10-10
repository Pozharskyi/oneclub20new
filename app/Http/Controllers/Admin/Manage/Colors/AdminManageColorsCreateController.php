<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:45
 */

namespace App\Http\Controllers\Admin\Manage\Colors;

use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\Product\ProductColorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManageColorsCreateController extends AdminManageColorsValidationController implements AdminImportCreateInterface
{
    public function actionGetCreateView( Request $request )
    {
        return view( 'admin.manage.colors.create' );
    }

    public function actionCreate( Request $request )
    {
        $color_name = $request->input( 'color_name' );

        if( Auth::guest() )
        {
            return redirect( '/login' );
        } else
        {
            $user_id = Auth::user()->id;
        }

        $existence = $this->actionValidateIfColorExists( $color_name );

        if( $existence === false )
        {
            try
            {
                ProductColorModel::create([
                    'name' => $color_name,
                    'made_by' => $user_id,
                ]);

                return redirect('/admin/manage/colors?alert=created');

            } catch (\Exception $e)
            {
                return redirect('/admin/manage/colors?alert=failed');
            }
        } else
        {
            return redirect( '/admin/manage/colors?alert=color_exists' );
        }
    }

}