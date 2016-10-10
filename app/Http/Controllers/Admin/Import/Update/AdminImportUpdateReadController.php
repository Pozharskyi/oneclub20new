<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 27.09.2016
 * Time: 17:03
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Models\Import\ImportUpdateModel;
use Illuminate\Http\Request;

/**
 * Main index for getting update parties
 * information to read for UI
 * Class AdminImportUpdateReadController
 * @package App\Http\Controllers\Admin\Import\Update
 */
class AdminImportUpdateReadController extends Controller implements AdminImportReadInterface
{
    /**
     * Getting Import Update
     * description information
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionRead( Request $request )
    {
        $data = ImportUpdateModel::with(['user'])
            ->get();

        // getting view
        return view('admin.import.update.read', [
            'data' => $data,
        ]);
    }

}