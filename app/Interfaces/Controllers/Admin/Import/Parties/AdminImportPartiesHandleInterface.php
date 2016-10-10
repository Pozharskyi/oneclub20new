<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:20
 */

namespace App\Interfaces\Controllers\Admin\Import\Parties;

use Illuminate\Http\Request;

/**
 * Main handler for products control
 * In parties process logic
 * Interface AdminImportPartiesHandleInterface
 * @package app\Interfaces\Controllers\Admin\Import\Parties
 */
interface AdminImportPartiesHandleInterface
{
    /**
     * Action handle product
     * With type of handling
     * @param Request $request
     * @return mixed
     */
    public function actionHandleProduct( Request $request );
}