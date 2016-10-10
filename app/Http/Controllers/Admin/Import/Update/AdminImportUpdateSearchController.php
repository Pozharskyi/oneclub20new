<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 19:19
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesSuppliersTrait;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesUsersTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportSearchInterface;
use App\Models\Import\ImportUpdateModel;
use Illuminate\Http\Request;

class AdminImportUpdateSearchController extends Controller implements AdminImportSearchInterface
{
    use AdminImportPartiesSuppliersTrait;
    use AdminImportPartiesUsersTrait;

    /**
     * Getting search View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetSearchView()
    {
        // getting all users
        $users = $this->actionGetAllUpdateUsers();

        return view('admin.import.update.search', [
            'users' => $users,
        ]);
    }

    /**
     * Make search by any param
     * Based on Request
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearch( Request $request )
    {
        // search fields
        $search = [
            'id', 'update_name',
            'recommended_start', 'made_by'
        ];

        $fields = array();

        // foreach field validate
        foreach( $search as $data )
        {
            $item = $request->input( $data );

            if( isset( $item ) && $item != '' )
            {
                $fields[$data] = $item;
            }
        }

        // getting parties
        $updates = ImportUpdateModel::search( $fields )
            ->with(['user'])->get();

        // count parties
        $count = count( $updates );

        return view( 'admin.import.update.searchResults', [
            'updates' => $updates,
            'count' => $count,
        ]);
    }

}