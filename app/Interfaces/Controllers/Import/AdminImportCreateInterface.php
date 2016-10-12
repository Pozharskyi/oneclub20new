<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 14:17
 */

namespace App\Interfaces\Controllers\Import;

use App\Http\Requests\Request;

/**
 * Getting creation interface
 * for import package
 * Interface AdminImportCreateInterface
 * @package App\Interfaces\Controllers\Import
 */
interface AdminImportCreateInterface
{
    /**
     * Getting creation view
     * @param Request $request
     * @return mixed
     */
    public function actionGetViewForCreate(Request $request);

    /**
     * Handling create request
     * @param Request $request
     * @return mixed
     */
    public function actionCreate(Request $request);

}