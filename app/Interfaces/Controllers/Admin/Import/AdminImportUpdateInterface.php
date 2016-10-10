<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:58
 */

namespace App\Interfaces\Controllers\Admin\Import;

use Illuminate\Http\Request;

/**
 * Main interface to control update dependency
 * Interface AdminImportUpdateInterface
 * @package app\Interfaces\Controllers\Admin\Import
 */
interface AdminImportUpdateInterface
{
    /**
     * Getting update method
     * @param Request $request
     * @return mixed
     */
    public function actionUpdate( Request $request );

}