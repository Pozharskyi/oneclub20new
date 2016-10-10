<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.09.2016
 * Time: 16:36
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\Import\ImportPartiesModel;
use Illuminate\Http\Request;

/**
 * Handler of parties read information
 * for UI
 * Class AdminImportPartiesReadController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesReadController extends Controller implements AdminImportReadInterface
{
    /**
     * Getting all available parties
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionRead( Request $request )
    {
        $catalog = $this->actionGetPartiesData( 1 );
        $sale = $this->actionGetPartiesData( 2 );

        return view('admin.import.parties.read', [
            'catalog' => $catalog,
            'sale' => $sale,
        ]);
    }

    /**
     * Getting parties data
     * based on party category
     * @param $party_category_id
     * @return mixed
     */
    private function actionGetPartiesData( $party_category_id )
    {
        $parties = ImportPartiesModel::where( 'party_category_id', $party_category_id )
            ->with(['user', 'supplier', 'partiesProcess'])
            ->get();

        return $parties;
    }

}