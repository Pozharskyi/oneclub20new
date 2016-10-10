<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 23:36
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportSearchInterface;
use Illuminate\Http\Request;

use App\Models\Import\ImportSalesShareModel;

/**
 * Searching for share by phrase
 * or dates
 * Class AdminImportShareSearchController
 * @package App\Http\Controllers\Admin\Import\Share
 */
class AdminImportShareSearchController extends Controller implements AdminImportSearchInterface
{
    /**
     * Handling search by
     * @param search
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearch( Request $request )
    {
        $search = $request->input('search');

        $shares = $shares = ImportSalesShareModel::search( $search )
            ->with(['user', 'salesAssociation' => function( $query )
            {
                $query->groupBy('share_id')->count();
            }])->get();

        $count = count( $shares );

        // getting view
        return view('admin.import.share.search', [
            'shares' => $shares,
            'count' => $count,
        ]);
    }

}