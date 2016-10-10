<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:42
 */

namespace App\Interfaces\Controllers\Admin\Import;
use Illuminate\Http\Request;

/**
 * Main interface to control read dependency
 * Interface AdminImportReadInterface
 * @package App\Interfaces\Controllers\Admin\Import
 */
interface AdminImportReadInterface
{
    /**
     * Getting read method
     * @param Request $request
     * @return mixed
     */
    public function actionRead( Request $request );

}