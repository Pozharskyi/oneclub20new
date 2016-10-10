<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 12:09
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Models\Import\ImportPartiesModel;
use App\Models\Import\ImportUpdateModel;

/**
 * Getting All information about users
 * in Parties Import
 * Class AdminImportPartiesUsersTrait
 * @package App\Http\Controllers\Admin\Import\Parties
 */
trait AdminImportPartiesUsersTrait
{
    /**
     * Getting all parties
     * users list
     * @return mixed
     */
    public function actionGetAllPartiesUsers()
    {
        $users = ImportPartiesModel::groupBy( 'made_by' )
            ->with(['user'])
            ->get();

        return $users;
    }

    /**
     * Getting all update
     * users list
     * @return mixed
     */
    public function actionGetAllUpdateUsers()
    {
        $users = ImportUpdateModel::groupBy( 'made_by' )
            ->with(['user'])
            ->get();

        return $users;
    }

}