<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 11:44
 */

namespace App\Http\Controllers\Admin\Import\Control;

use App\Http\Controllers\Traits\Product\ProductCategoriesTrait;
use Illuminate\Http\Request;

class AdminImportControlPartiesController extends AdminImportControlPartiesValidationController
{
    use ProductCategoriesTrait;

    public function actionManageParties(Request $request)
    {

    }

}