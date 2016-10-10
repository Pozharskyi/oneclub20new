<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:52
 */

namespace App\Interfaces\Controllers\Admin\Import\Share;

/**
 * Main share description interface
 * Getting Statuses list
 * Based on parties
 * Interface AdminImportShareDescriptionInterface
 * @package App\Interfaces\Controllers\Admin\Import\Share
 */
interface AdminImportShareDescriptionInterface
{
    /**
     * Getting all non active parties
     * From the whole parties list
     * @return mixed
     */
    public function actionGetNonActiveParties();

    /**
     * Getting all parties
     * From the whole parties list
     * @return mixed
     */
    public function actionGetAllParties();

}