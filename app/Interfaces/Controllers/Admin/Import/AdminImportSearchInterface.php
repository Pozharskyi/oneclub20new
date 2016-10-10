<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:48
 */

namespace App\Interfaces\Controllers\Admin\Import;

use Illuminate\Http\Request;

/**
 * Main interface for searching
 * any data in Controller
 * Interface AdminImportSearchInterface
 * @package app\Interfaces\Controllers\Admin\Import
 */
interface AdminImportSearchInterface
{
    /**
     * Search matches based
     * on request Fields
     * @param Request $request
     * @return mixed
     */
    public function actionSearch( Request $request );

}