<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 11.10.2016
 * Time: 23:31
 */

namespace App\Http\Controllers\Admin\Import;

use App\Http\Controllers\Controller;

class AdminImportIndexController extends Controller
{
    public function actionIndex()
    {
        return view('admin.import.index');
    }

}