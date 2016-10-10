<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 11:46
 */

namespace App\Http\Controllers\Admin\Manage\Brands;

use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use App\Models\Basic\BasicBrandsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminManageBrandsUpdateController extends AdminManageBrandsValidationController implements AdminImportUpdateInterface
{
    public function actionGetUpdateView( $brand_id )
    {
        $brand = BasicBrandsModel::with(['user'])
            ->find( $brand_id );

        return view( 'admin.manage.brands.update', [
            'brand' => $brand,
        ]);
    }

    public function actionUpdate( Request $request )
    {
        $brand_name = $request->input( 'brand_name' );
        $brand_id = $request->input( 'brand_id' );

        if( Auth::guest() )
        {
            return redirect( '/login' );
        } else
        {
            $user_id = Auth::user()->id;
        }

        $existence = $this->actionValidateIfBrandExists( $brand_name );

        if( $existence === false )
        {
            try
            {
                $brand = BasicBrandsModel::findOrFail( $brand_id );
                $brand->brand_name = $brand_name;
                $brand->made_by = $user_id;

                $brand->save();

                return redirect( '/admin/manage/brands?alert=success' );
            } catch( \Exception $e )
            {
                return redirect( '/admin/manage/brands?alert=failed' );
            }
        } else
        {
            return redirect( '/admin/manage/brands?alert=brand_exists' );
        }
    }

}