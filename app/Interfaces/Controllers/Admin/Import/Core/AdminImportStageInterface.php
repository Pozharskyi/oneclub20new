<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:15
 */

namespace App\Interfaces\Controllers\Admin\Import\Core;


/**
 * Main interface for Import Stages
 * Includes pushing stages, not forcing push
 * i.e. Without any errors presents
 * Getting of stages, counting errors and clearing stages
 * Interface AdminImportStageInterface
 * @package app\Interfaces\Controllers\Admin\Import\Core
 */
interface AdminImportStageInterface
{
    /**
     * Pushing stage to exist array
     * @param $fat_status
     * @param $stage
     * @return mixed
     */
    public function actionPushStage( $fat_status, $stage );

    /**
     * Not force pushing stages to exist array
     * Without any errors present
     * @param $fat_status
     * @param $stage
     * @return mixed
     */
    public function actionNotForcePush( $fat_status, $stage );

    /**
     * Getting all stages
     * @return mixed
     */
    public function actionGetStages();

    /**
     * Counting all stages with errors
     * @return mixed
     */
    public function actionCountStages();

    /**
     * Clearing all stages
     * @return mixed
     */
    public function actionClearStages();

}