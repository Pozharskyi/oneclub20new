<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 14.10.2016
 * Time: 19:28
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;

class AdminImportPartiesDescriptionController extends Controller
{
    public function actionGetDescription(Request $request)
    {
        $party_id = $request->input('party_id');

        $allocation = Allocation::actionGetAllocation($party_id);
        $rows = $allocation->file;
        $allocationId = $allocation->allocationId;

        return view('admin.import.parties.description', [
            'rows' => $rows,
            'count' => count( $rows ),

            'party_id' => $party_id,
            'allocationId' => $allocationId,
        ]);
    }

}