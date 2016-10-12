<?php

/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 14:15
 */

namespace App\Interfaces\Controllers\Import;

/**
 * Getting basic interface for reading
 * import package
 * Interface AdminImportReadInterface
 * @package App\Interfaces\Controllers\Import
 */
interface AdminImportReadInterface
{
    /**
     * Getting view for reading
     * @param null $param
     * @return mixed
     */
    public function actionGetViewForRead( $param = null );

}