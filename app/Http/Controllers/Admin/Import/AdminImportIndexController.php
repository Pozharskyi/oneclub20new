<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 21.09.2016
 * Time: 11:40
 */

namespace App\Http\Controllers\Admin\Import;

use App\Http\Controllers\Controller;

/**
 * Main page for import
 * Includes documentation of
 * how to handle it
 * Class AdminImportIndexController
 * @package App\Http\Controllers\Admin\Import
 */
class AdminImportIndexController extends Controller
{
    /**
     * Getting documentation view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex()
    {
        // getting view
        return view('admin.import.index');
    }

}