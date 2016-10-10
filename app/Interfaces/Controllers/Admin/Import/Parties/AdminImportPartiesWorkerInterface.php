<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:23
 */

namespace App\Interfaces\Controllers\Admin\Import\Parties;

use Illuminate\Http\Request;

/**
 * Includes main index for going
 * to handle Request in order to edit
 * product from import parties
 * Interface AdminImportPartiesWorkerInterface
 * @package app\Interfaces\Controllers\Admin\Import\Parties
 */
interface AdminImportPartiesWorkerInterface
{
    /**
     * Handler of Request in order
     * to edit product
     * @param Request $request
     * @return mixed
     */
    public function actionIndex( Request $request );

}