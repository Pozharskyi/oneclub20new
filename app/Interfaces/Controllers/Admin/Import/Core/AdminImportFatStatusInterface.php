<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 17:11
 */

namespace App\Interfaces\Controllers\Admin\Import\Core;

/**
 * Main Interface to control Fat Status
 * Realizes conjunction of needle in statuses
 * Setter statuses, Getter of statuses,
 * Deny of statuses, Search status
 * Interface AdminImportFatStatusInterface
 * @package App\Interfaces\Controllers\Admin\Import\Core
 */
interface AdminImportFatStatusInterface
{
    /**
     * Getting statuses
     * @param $association_phrase
     * @return mixed
     */
    public function actionSetStatuses( $association_phrase );

    /**
     * Searching association
     * By phrase
     * @param $association_phrase
     * @return mixed
     */
    public function actionSearchAssociationByPhrase( $association_phrase );

    /**
     * Searching Status
     * By phrase
     * @param $association_phrase
     * @return mixed
     */
    public function actionSearchStatusByPhrase( $association_phrase );

    /**
     * Validate if status
     * is available in statuses
     * @param $search
     * @return mixed
     */
    public function actionValidateStatus( $search );

    /**
     * Getting all available statuses
     * @return mixed
     */
    public function actionGetStatuses();

    /**
     * Deny statuses
     * @return mixed
     */
    public function actionResetStatuses();

}