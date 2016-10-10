<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Core\AdminImportFatStatusInterface;
use App\Models\Import\ImportFatAssociationStatusModel;
use App\Models\Import\ImportFatStatusModel;

/**
 * Fat status handler for updating and making
 * Parties of items
 * Includes setter, validator, searcher
 * and unsetter
 * Class AdminImportFatStatusController
 * @package App\Http\Controllers\Admin\Import\Core
 */
class AdminImportFatStatusController extends Controller implements AdminImportFatStatusInterface
{
    /**
     * Includes all available statuses
     * for current operation
     * @var array
     */
    private $statuses = array();

    /**
     * Searching status by phrase
     * Getting all ids that compatible for association
     * Going through allocation table for
     * statuses list
     * @param $associationPhrase
     * @return int
     */
    public function actionSetStatuses($associationPhrase)
    {
        $statuses = ImportFatAssociationStatusModel::search($associationPhrase)
            ->with(['fatAllocation'])
            ->first();

        $fatStatuses = array();

        foreach ($statuses->fatAllocation as $status) {
            $id = $status->fat_status_id;

            array_push($fatStatuses, $id);
        }

        $this->statuses = $fatStatuses;

        return 0;
    }

    /**
     * Pushing only error
     * status for exists
     */
    public function actionPushErrorStatus()
    {
        $this->statuses[] = $this->actionSearchStatusByPhrase('ERROR');
    }

    /**
     * Searching association id
     * by phrase
     * @param $associationPhrase
     * @return mixed
     */
    public function actionSearchAssociationByPhrase($associationPhrase)
    {
        $status = ImportFatAssociationStatusModel::where('short_phrase', $associationPhrase)
            ->first(['id']);

        return $status->id;
    }

    /**
     * Searching fat status by phrase
     * if exists return id
     * else return false
     * @param $associationPhrase
     * @return bool
     */
    public function actionSearchStatusByPhrase($associationPhrase)
    {
        $status = ImportFatStatusModel::findStatus($associationPhrase)
            ->first(['id']);

        if (isset($status->id)) {
            return $status->id;
        }

        return false;
    }

    /**
     * Getting fat status by id
     * @param $statusId
     * @return mixed
     */
    public function actionGetFullStatusById($statusId)
    {
        $status = ImportFatStatusModel::findOrFail($statusId);

        return $status->fat_status;
    }

    /**
     * Validate if current status we used
     * we could handle this for our
     * operation type
     * @param $search
     * @return bool
     */
    public function actionValidateStatus($search)
    {
        if (in_array($search, $this->statuses)) {
            return true;
        }

        return false;
    }

    /**
     * Getting all available statuses
     * for current operation
     * @return array
     */
    public function actionGetStatuses()
    {
        return $this->statuses;
    }

    /**
     * Status ruining
     * for next operation type
     */
    public function actionResetStatuses()
    {
        $this->statuses = array();
    }

}