<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin\Manage\Sizes;

use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductSizeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManageSizesUpdateController extends AdminManageSizesValidationController implements AdminImportUpdateInterface
{
    public function actionGetUpdateView( $size_id )
    {
        $size = ProductSizeModel::with(['user'])
            ->find( $size_id );

        return view( 'admin.manage.sizes.update', [
            'size' => $size,
        ]);
    }

    public function actionUpdate( Request $request )
    {
        $size_name = $request->input( 'size_name' );
        $size_id = $request->input( 'size_id' );

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
                $size = ProductSizeModel::findOrFail( $size_id );
                $size->name = $size_name;
                $size->made_by = $user_id;

                $size->save();

                return redirect( '/admin/manage/sizes?alert=success' );
            } catch( \Exception $e )
            {
                return redirect( '/admin/manage/sizes?alert=failed' );
            }
        } else
        {
            return redirect( '/admin/manage/sizes?alert=size_exists' );
        }
    }

}