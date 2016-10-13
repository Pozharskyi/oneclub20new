<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 13:18
 */

namespace App\Http\Controllers\Admin\Import\Uploading;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Import\AdminImportCreateInterface;
use App\Models\Import\ImportIndexPartiesModel;
use Illuminate\Http\Request;

class AdminImportUploadingCreateController extends Controller implements AdminImportCreateInterface
{
    public function actionGetViewForCreate(Request $request)
    {
        $party_id = $request->input('party_id');

        $party = ImportIndexPartiesModel::findOrFail($party_id);

        return view('admin.import.uploading.create', [
            'party_id' => $party_id,
            'party' => $party,
        ]);
    }

    public function actionCreate(Request $request)
    {

    }

}