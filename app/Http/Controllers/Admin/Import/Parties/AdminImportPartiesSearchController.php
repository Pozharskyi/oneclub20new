<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 12:05
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportSearchInterface;
use App\Models\Import\ImportPartiesModel;
use Illuminate\Http\Request;

/**
 * Handler search for parties import
 * Getting search view
 * Getting search results
 * Class AdminImportPartiesSearchController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesSearchController extends Controller implements AdminImportSearchInterface
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
        $users = $this->actionGetAllPartiesUsers();

        // getting all suppliers
        $suppliers = $this->actionGetAllPartiesSuppliers();

        return view('admin.import.parties.search', [
            'users' => $users,
            'suppliers' => $suppliers,
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
            'id', 'party_name', 'supplier_id',
            'recommended_start', 'recommended_end',
            'made_by'
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
        $parties = ImportPartiesModel::search( $fields )
            ->with([
                'supplier', 'user',
                'partiesCategory'
            ])->get();

        // count parties
        $count = count( $parties );

        return view( 'admin.import.parties.searchResults', [
            'parties' => $parties,
            'count' => $count,
        ]);
    }

}