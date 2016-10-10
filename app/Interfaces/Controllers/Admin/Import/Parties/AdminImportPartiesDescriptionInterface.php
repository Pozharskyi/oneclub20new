<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 18:11
 */

namespace App\Interfaces\Controllers\Admin\Import\Parties;

/**
 * Getting party description
 * Based on party identity
 * Interface AdminImportPartiesDescriptionInterface
 * @package App\Interfaces\Controllers\Admin\Import\Parties
 */
interface AdminImportPartiesDescriptionInterface
{
    /**
     * Getting basic information
     * of party by identity
     * @param $party_id
     * @return mixed
     */
    public function actionGetPartyInfo( $party_id );

    /**
     * Getting fat information
     * of party by identity
     * @param $party_id
     * @return mixed
     */
    public function actionGetFatInfo( $party_id );

}