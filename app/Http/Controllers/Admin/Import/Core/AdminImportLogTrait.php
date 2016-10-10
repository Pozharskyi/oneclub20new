<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 25.09.2016
 * Time: 18:41
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Import\ImportLogUpdateProcessModel;
use App\Models\Import\ImportUpdateProcessModel;
use App\Models\Product\SubProductModel;
use App\Models\Import\ImportLogPartiesProcessModel as Process;
use App\Models\Import\ImportPartiesProcessModel;

/**
 * Main logger for import
 * Includes logging for updating and creation
 * of parties and shares
 * Logger of import lines & update lines
 * Includes Stage controller to log with
 * Errors reporting
 * Class AdminImportLogTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportLogTrait
{
    /**
     * Fat status manager
     * for operations
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Create of new Fat status manage
     * Controller for operations
     * AdminImportLogTrait constructor.
     */
    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController();
    }

    /**
     * Logging import line as well as validation
     * of current operation type
     * Available only for Search matching category
     * if status is not found get error Fat status
     * @param AdminImportStageController $stage
     * @param $line
     * @param $party_id
     * @param $product_id
     * @param $color_id
     * @param $supplier
     * @param $barcode
     */
    public function actionLogImportLine(AdminImportStageController $stage, $line, $party_id, $product_id, $color_id, $supplier, $barcode)
    {
        if (!isset($this->fat)) {
            $this->fat = new AdminImportFatStatusController();
        }

        // only search types
        $this->fat->actionSetStatuses('SEARCH');

        $info = $this->actionLogSubProduct($product_id, $color_id, $barcode, $supplier);
        $fat_status = $info->fat_status;

        if ($this->fat->actionValidateStatus($fat_status)) {
            if ($fat_status == 1 || $fat_status == 2) {
                $stage->actionPushStage('WARNING', 'Найден похожий товар: ' . $info->uri);
            }
        } else {
            $fat_status = $this->fat->actionSearchStatusByPhrase('SYSTEM_ERROR');
        }

        Process::create([
            'party_id' => $party_id,
            'file_line' => $line,
            'fat_status_id' => $fat_status,
            'sub_product_id' => $info->sub_product_id,
            'message' => '',
        ]);

        // destroy status object
        $this->fat->actionResetStatuses();
    }

    public function actionFindSubProductByLine($partyId, $fileLine)
    {
        $newStatus = $this->fat->actionSearchStatusByPhrase('NEW');

        $product = Process::confirmationUpdate($partyId, $fileLine, $newStatus)
            ->first(['sub_product_id']);

        $subProductId = $product->sub_product_id;

        return $this->actionSearchSubProductUrl($subProductId);
    }

    public function actionSearchSubProductUrl($subProductId)
    {
        $data = SubProductModel::with(['product'])
            ->findOrFail($subProductId);

        return '/list/' . $data->product->product_store_id . '/' . $data->dev_product_color_id;
    }

    public function actionLogProductIfNew($fileLine, $partyId, $subProductId)
    {
        $new = $this->fat->actionSearchStatusByPhrase('NEW');

        Process::confirmationUpdate($partyId, $fileLine, $new)
            ->update([
                'sub_product_id' => $subProductId,
            ]);
    }

    /**
     * Logging errors in process
     * of Creation of items as well as Updaing items
     * @param $partyId
     * @param $fileLine
     */
    public function actionLogError($partyId, $fileLine)
    {
        // only for search
        $status = $this->fat->actionSetStatuses('SEARCH');

        if (!$this->fat->actionValidateStatus($status)) {
            $status = $this->fat->actionSearchStatusByPhrase('SYSTEM_ERROR');
        }

        Process::create([
            'party_id' => $partyId,
            'file_line' => $fileLine,
            'fat_status_id' => $status,
            'message' => '',
        ]);

        // reset status object
        $this->fat->actionResetStatuses();
    }

    /**
     * Clearing all logs based
     * on new operation type
     * for working party and line
     * @param $line
     * @param $partyId
     */
    public function actionClearLogs($line, $partyId)
    {
        Process::where('party_id', $partyId)
            ->where('file_line', $line)
            ->delete();
    }

    /**
     * Clearing all logs based
     * on new operation type
     * for updating party and line
     * @param $line
     * @param $partyId
     */
    public function actionClearUpdateLogs($line, $partyId)
    {
        ImportLogUpdateProcessModel::where('update_id', $partyId)
            ->where('file_line', $line)
            ->delete();
    }

    /**
     * Logging an error based on Error as well as Notices
     * Association list
     * If not valid status return ERROR Message
     * if valid insert for logs
     * @param AdminImportStageController $stage
     * @param $line
     * @param $partyId
     */
    public function actionLogImport(AdminImportStageController $stage, $line, $partyId)
    {
        $stages = $stage->actionGetStages();

        // set statuses only for notices
        $this->fat->actionSetStatuses('NOTICE');

        foreach ($stages as $type) {
            if (!$this->fat->actionValidateStatus($type['fat_status'])) {
                $type['fat_status'] = $this->fat->actionSearchStatusByPhrase('SYSTEM_ERROR');
            }

            Process::create([
                'party_id' => $partyId,
                'file_line' => $line,
                'fat_status_id' => $type['fat_status'],
                'message' => $type['stage'],
            ]);
        }

        // destroy statuses object
        $this->fat->actionResetStatuses();
    }

    /**
     * Logging all info about found
     * sub product
     * Setting only for matching Statuses
     * If found in user - make allocation for him
     * If found in another users - make allocation for anothers
     * Else new product creation process
     * @param $productId
     * @param $colorId
     * @param $barcode
     * @param $supplier
     * @return \stdClass
     */
    public function actionLogSubProduct($productId, $colorId, $barcode, $supplier)
    {
        // only for search statuses
        $this->fat->actionSetStatuses('SEARCH');

        $log = SubProductModel::where('dev_product_index_id', $productId)
            ->where('dev_product_color_id', $colorId)
            ->where('barcode', $barcode)
            ->with(['product'])
            ->get();

        $suppliers = array();

        foreach ($log as $info) {
            array_push($suppliers, $info->supplier_id);
        }

        /**
         * If no errors found
         */
        if (count($log) != 0) {
            if (in_array($supplier, $suppliers)) {
                // found in his items
                $fatStatus = 'OWN_FOUND';
                $subProductId = $log[0]->id;
            } else {
                // found in others items
                $fatStatus = 'OTHERS_FOUND';
                $subProductId = $log[0]->id;
            }
        } else {
            // new item
            $fatStatus = 'NEW';
            $subProductId = null;
        }

        /**
         * If found in his items
         * or in anothers items
         */
        if ($fatStatus == 'OWN_FOUND' || $fatStatus == 'OTHERS_FOUND') {
            $uri = '/list/' . $log[0]->product->product_store_id . '/' . $colorId;
        } else {
            $uri = '';
        }

        /**
         * Searing status by phrase
         * of founding in previous
         * operations list
         */
        $fat = $this->fat->actionSearchStatusByPhrase($fatStatus);

        // if is valid
        if (!$this->fat->actionValidateStatus($fat)) {
            $fat = $this->fat->actionSearchStatusByPhrase('SYSTEM_ERROR');
        }

        $result = new \stdClass();
        $result->product_id = $productId;
        $result->fat_status = $fat;
        $result->uri = $uri;
        $result->sub_product_id = $subProductId;

        /**
         * Return object of finding data
         */
        return $result;
    }

    /**
     * Updating import logs
     * Statuses only for update
     * make log based on status found for update
     * @param AdminImportFatStatusController $status
     * @param $update_id
     * @param $file_line
     * @param $fat_status
     * @param $sub_product_id
     * @return ImportLogUpdateProcessModel
     */

    public function actionLogUpdateImport( AdminImportFatStatusController $status, $update_id, $file_line, $fat_status, $sub_product_id )
    {
        // set statuses only for update
        $this->fat->actionSetStatuses('UPDATE');

        // validate status for line
        if( !$this->fat->actionValidateStatus( $fat_status ) )
        {
            $fat_status = $status->actionSearchStatusByPhrase( 'SYSTEM_ERROR' );
        }

        // create logging line
        return ImportLogUpdateProcessModel::create([
            'update_id' => $update_id,
            'file_line' => $file_line,
            'fat_status_id' => $fat_status,
            'sub_product_id' => $sub_product_id,
        ]);
    }

    /**
     * Updating party log
     * If log is over make new Status as Ready
     * another way, only make increment for new lines
     * to parse in another try
     * @param $import
     * @param $limitUsed
     * @param $end
     */
    public function actionUpdatePartyLog($import, $limitUsed, $end)
    {
        $line = $import->id;

        $update = ImportPartiesProcessModel::findOrFail($line);
        $update->in_process_atm = $end;

        // if all items are parsed
        if ($limitUsed) {
            $update->fat_status = 'Готово';
        }

        $update->save();
    }

    /**
     * Updating update log
     * If log is over make new Status as Ready
     * another way, only make increment for new lines
     * to parse in another try
     * @param $import
     * @param $limitUsed
     * @param $end
     */
    public function actionLogUpdate($import, $limitUsed, $end)
    {
        $line = $import->id;

        $update = ImportUpdateProcessModel::findOrFail($line);
        $update->in_process_atm = $end;

        // if all items are parsed
        if ($limitUsed) {
            $update->fat_status = 'Готово';
        }

        $update->save();
    }

    /**
     * Make logging for updating with stages
     * Only available for notices list
     * Make all stages logged for line and party
     * @param AdminImportStageController $stage
     * @param $line
     * @param $updateId
     */
    public function actionLogUpdateStagesImport(AdminImportStageController $stage, $line, $updateId)
    {
        $stages = $stage->actionGetStages();

        // setting statuses available only for notices
        $this->fat->actionSetStatuses('NOTICE');

        // foreach stages parse
        foreach ($stages as $type) {
            // validate if stage is available
            if (!$this->fat->actionValidateStatus($type['fat_status'])) {
                $type['fat_status'] = $this->fat->actionSearchStatusByPhrase('SYSTEM_ERROR');
            }

            // create log line
            ImportLogUpdateProcessModel::create([
                'update_id' => $updateId,
                'file_line' => $line,
                'fat_status_id' => $type['fat_status'],
                'message' => $type['stage'],
            ]);
        }

        // resetting statuses object
        $this->fat->actionResetStatuses();
    }

}