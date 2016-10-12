<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 12:45
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Import\AdminImportReadInterface;
use App\Models\Import\ImportIndexPartiesModel;

class AdminImportPartiesReadController extends Controller implements AdminImportReadInterface
{
    private $partiesStatus;

    public function __construct()
    {
        $this->partiesStatus = new AdminImportPartiesStatusController;
    }

    public function actionGetViewForRead( $buyer_id = null )
    {
        $parties = ImportIndexPartiesModel::sortByBuyer( $buyer_id )
            ->with([
                'partiesStatus', 'buyer',
                'supplier', 'importCategory',
            ])->get();

        $deleted = $this->partiesStatus->actionGetStatusIdByPhrase('DELETED');

        return view( 'admin.import.parties.read', [
            'parties' => $parties,
            'deleted' => $deleted,
            'count' => count( $parties ),
        ]);
    }

}