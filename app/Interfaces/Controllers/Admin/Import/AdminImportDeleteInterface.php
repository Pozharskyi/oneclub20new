<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:37
 */

namespace App\Interfaces\Controllers\Admin\Import;

use Illuminate\Http\Request;

/**
 * Main interface for deletion items
 * Interface AdminImportDeleteInterface
 * @package app\Interfaces\Controllers\Admin\Import
 */
interface AdminImportDeleteInterface
{
    /**
     * Handle deletion
     * @param Request $request
     * @return mixed
     */
    public function actionDelete( Request $request );

}