<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 23:08
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportUpdateInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Import\ImportSalesAssociationModel;
use App\Models\Import\ImportSalesShareModel;

/**
 * Updating existing parties for share
 * with deletion of parties as well as shares
 * Class AdminImportShareUpdateController
 * @package App\Http\Controllers\Admin\Import\Share
 */
class AdminImportShareUpdateController extends Controller implements AdminImportUpdateInterface
{
    /**
     * Updating share by request types
     * With parties including
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionUpdate( Request $request )
    {
        // if not user get redirect
        // for Auth page
        if( !isset( Auth::user()->id ) )
        {
            return redirect('/login');
        }

        $share_id = $request->input('share_id');

        $share_name = $request->input('share_name');
        $share_start = $request->input('recommended_start');
        $share_end = $request->input('recommended_end');

        // updating share info
        $this->actionUpdateMain( $share_id, $share_name, $share_start, $share_end );

        // deleting all parties in share
        $this->actionDeleteShareParties( $share_id );

        $parties = $request->input('parties');

        // if no parties found
        if( !is_null( $parties ) )
        {
            foreach( $parties as $party )
            {
                $this->actionUpdateParties( $share_id, $party );
            }
        }

        // get redirect for success page
        return redirect('/admin/import/share/?success=changed');
    }

    /**
     * Updating update info
     * Based on name, start, end
     * By share id
     * @param $id
     * @param $name
     * @param $start
     * @param $end
     */
    private function actionUpdateMain( $id, $name, $start, $end )
    {
        $share = ImportSalesShareModel::findOrFail( $id );

        $share->sales_share_name = $name;
        $share->sales_share_start = $start;
        $share->sales_share_end = $end;

        $share->save();
    }

    /**
     * Deleting share parties from
     * share sales
     * @param $share_id
     */
    private function actionDeleteShareParties( $share_id )
    {
        ImportSalesAssociationModel::where( 'share_id', $share_id )
            ->delete();
    }

    /**
     * Updating parties association
     * and Allocation table
     * @param $share_id
     * @param $party_id
     */
    private function actionUpdateParties( $share_id, $party_id )
    {
        ImportSalesAssociationModel::create([
            'party_id' => $party_id,
            'share_id' => $share_id,
            'made_by' => Auth::user()->id,
        ]);
    }

}