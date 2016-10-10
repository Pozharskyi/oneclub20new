<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 21:07
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use Illuminate\Http\Request;

use App\Models\Import\ImportSalesShareModel;

/**
 * Getting shares view
 * For handling actions
 * Class AdminImportShareReadController
 * @package App\Http\Controllers\Admin\Import\Share
 */
class AdminImportShareReadController extends Controller implements AdminImportReadInterface
{
    /**
     * Getting all shares
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionRead( Request $request )
    {
        $message = $request->input('success');

        if( !isset( $message ) )
        {
            $message = null;
        }

        $shares = ImportSalesShareModel::with(['user', 'salesAssociation' => function( $query )
        {
            $query->groupBy('share_id')->count();
        }])->get();

        // getting view
        return view('admin.import.share.read', [
            'shares' => $shares,
            'message' => $message,
        ]);
    }

}