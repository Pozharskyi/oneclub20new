<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.10.2016
 * Time: 14:18
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Models\Import\ImportPartiesModel;

trait AdminImportPartiesTrait
{
    public function actionGetPartyStart($partyId)
    {
        $party = ImportPartiesModel::findOrFail($partyId);
        
        return date('Y-m-d', $party->created_at);
    }

}