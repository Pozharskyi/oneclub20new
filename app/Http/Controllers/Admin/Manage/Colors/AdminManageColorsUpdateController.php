<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin\Manage\Colors;

use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Models\Product\ProductColorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManageColorsUpdateController extends AdminManageColorsValidationController implements AdminImportUpdateInterface
{
    public function actionGetUpdateView( $color_id )
    {
        $color = ProductColorModel::with(['user'])
            ->find( $color_id );

        return view( 'admin.manage.colors.update', [
            'color' => $color,
        ]);
    }

    public function actionUpdate( Request $request )
    {
        $color_name = $request->input( 'color_name' );
        $color_id = $request->input( 'color_id' );

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
                $brand = ProductColorModel::findOrFail( $color_id );
                $brand->name = $color_name;
                $brand->made_by = $user_id;

                $brand->save();

                return redirect( '/admin/manage/colors?alert=success' );
            } catch( \Exception $e )
            {
                return redirect( '/admin/manage/colors?alert=failed' );
            }
        } else
        {
            return redirect( '/admin/manage/colors?alert=color_exists' );
        }
    }

}