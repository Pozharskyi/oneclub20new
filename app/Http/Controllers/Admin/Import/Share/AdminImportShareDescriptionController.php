<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 22:35
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Share\AdminImportShareDescriptionInterface;
use App\Models\Import\ImportPartiesModel;
use Illuminate\Http\Request;

use App\Models\Import\ImportSalesShareModel;
use App\Models\Import\ImportSalesAssociationModel;

/**
 * Getting share description page
 * Getting all parties
 * with not active
 * Class AdminImportShareDescriptionController
 * @package App\Http\Controllers\Admin\Import\Share
 */
class AdminImportShareDescriptionController extends Controller implements AdminImportShareDescriptionInterface
{
    /**
     * Getting share description
     * based on id with Request type
     * @param Request $request
     * @param $share_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetShareDescription( Request $request, $share_id )
    {
        $message = $request->input('success');

        if( !isset( $message ) )
        {
            $message = null;
        }

        $share = ImportSalesShareModel::with([
                'user', 'salesAssociation',
                'salesAssociation.party'
            ])->findOrFail( $share_id );

        // all checked parties
        $checked = array();

        foreach( $share->salesAssociation as $assoc )
        {
            array_push( $checked, $assoc->party->id );
        }

        // all non active parties
        $nonActive = $this->actionGetNonActiveParties();

        // non checked
        // available parties
        $nonChecked = array();

        foreach( $nonActive as $item )
        {
            array_push( $nonChecked, $item->party_id );
        }

        // getting view
        return view('admin.import.share.description', [
            'share' => $share,
            'message' => $message,
            'share_id' => $share_id,

            'checked' => $checked,
            'nonActive' => $nonChecked,
            'parties' => $this->actionGetAllParties(),
        ]);
    }

    /**
     * Getting all non
     * active parties
     * @return mixed
     */
    public function actionGetNonActiveParties()
    {
        $parties = ImportSalesAssociationModel::groupBy('party_id')
            ->get(['party_id']);

        return $parties;
    }

    /**
     * Getting all parties
     * @return mixed
     */
    public function actionGetAllParties()
    {
        $parties = ImportPartiesModel::get();

        return $parties;
    }

}