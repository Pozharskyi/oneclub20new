<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 16.10.2016
 * Time: 3:05
 */

namespace App\Http\Controllers\Admin\Import\Statuses;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexPartiesModel;
use App\Models\Import\ImportPartiesStatusesModel;

class AdminImportStatusesPartiesController extends Controller
{
    private $prodStatus;

    public function __construct()
    {
        $this->prodStatus = $this->actionFindStatusIdByPhrase('PROCESSING');
    }

    public final function actionFindStatusIdByPhrase( $phrase )
    {
        $status = ImportPartiesStatusesModel::findStatus( $phrase )
            ->first(['id']);

        return $status->id;
    }

    public final function actionGetPartyStatusAvailability( $party_id )
    {
        $party = ImportIndexPartiesModel::find( $party_id );
        $partyStatus = $party->import_parties_status_id;

        if( $partyStatus == $this->prodStatus )
        {
            return 'denied';
        } else
        {
            return 'allowed';
        }
    }

}