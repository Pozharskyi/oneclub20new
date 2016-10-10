<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 27.09.2016
 * Time: 17:04
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportFatAllocationStatusModel;
use App\Models\Import\ImportLogUpdateProcessModel;
use App\Models\Import\ImportUpdateModel;

/**
 * Getting Description for Import Update
 * Includes working with fat statuses
 * Getting errors and parsing CSV
 * Class AdminImportUpdateDescriptionController
 * @package App\Http\Controllers\Admin\Import\Update
 */
class AdminImportUpdateDescriptionController extends Controller
{
    use AdminImportUpdateFileParserTrait;
    /**
     * Getting Fat Controller instance
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Initializing Fat instance
     * AdminImportUpdateDescriptionController constructor.
     */
    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController();
    }

    /**
     * Getting Fat Status View
     * Based on update
     * Restricted by status with UPDATE association
     * @param $update_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetFatStatusView( $update_id )
    {
        // restrict statuses
        $this->fat->actionSetStatuses( 'UPDATE' );

        $info = $this->actionGetUpdateInfo( $update_id );
        $fat_statuses = $this->actionGetDistinctFatStatus();

        // getting allocation result
        $results = $this->actionSearchFatStatus( $update_id, 0, 'fat' );

        return view('admin.import.update.fat', [
            'info' => $info,
            'fat_statuses' => $fat_statuses,

            'results' => $results,
            'count' => count( $results ),
        ]);
    }

    /**
     * Getting information about import update
     * Based on update id
     * @param $update_id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected function actionGetUpdateInfo( $update_id )
    {
        $info = ImportUpdateModel::with([
            'importUpdateProcess',
            'importLogUpdateProcess', 'user',
        ])->findOrFail( $update_id );

        // return object
        return $info;
    }

    /**
     * Getting distinct fat statuses
     * Based on restricted category
     * With Allocation Procedure
     * @param string $fat_status
     * @return mixed
     */
    protected function actionGetDistinctFatStatus( $fat_status = 'UPDATE' )
    {
        // getting association
        $new_item = $this->fat->actionSearchAssociationByPhrase( $fat_status );

        $fat = ImportFatAllocationStatusModel::where( 'fat_association_id', $new_item )
            ->with(['fatStatus'])
            ->get();

        // return allocation
        return $fat;
    }

    /**
     * Getting Data with fat status
     * Based on restricted statuses list
     * Getting line with status
     * @param $update_id
     * @param null $fat_status_id
     * @return mixed
     */
    protected function actionGetDataByFatStatus( $update_id, $fat_status_id = null )
    {
        if( $fat_status_id == 0 )
        {
            $fat_status_id = $this->fat->actionGetStatuses();
        }

        // getting all lines with available statuses
        $fat = ImportLogUpdateProcessModel::status( $update_id, $fat_status_id )
            ->get(['file_line', 'fat_status_id']);

        return $fat;
    }

    /**
     * Searching Fat status by closure
     * Two cases:
     * On the one hand,  to get results for current View
     * On the other hand, getting View to insert
     * By AJAX
     * @param $update_id
     * @param null $fat_status_id
     * @param null $for
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearchFatStatus( $update_id, $fat_status_id = null, $for = null )
    {
        if( $fat_status_id == 0 )
        {
            $fat_status_id = $this->fat->actionGetStatuses();
        }

        // getting data with fat statuses
        $fat = $this->actionGetDataByFatStatus( $update_id, $fat_status_id );

        // getting file
        $file = $this->actionGetCsvFile( $update_id );

        // getting results of parsing file
        // with statuses
        $results = $this->actionGetItemsResult( $fat, $file, $update_id );

        // resetting statuses object
        $this->fat->actionResetStatuses();

        if( is_null( $for ) )
        {
            // For first case, get view
            return view( 'admin.import.update.fat_resolve', [
                'results' => $results,
                'count' => count( $results ),
            ]);
        } else
        {
            // For the another case, get information
            return $results;
        }
    }

    /**
     * Getting result for file
     * With fat Allocation table
     * For update import id
     * @param $fat
     * @param $file
     * @param $update_id
     * @return array
     */
    protected function actionGetItemsResult( $fat, $file, $update_id )
    {
        $result = array();

        // foreach line
        foreach( $fat as $line )
        {
            // getting errors
            $errors = $this->actionSearchErrorsByLineAndParty( $line->file_line, $update_id );

            // getting first row to parse
            $data = $file[$line->file_line];

            // if errors exists
            if( $errors != 0 )
            {
                // set status of error
                $data['fat_status_id'] = $this->fat->actionSearchStatusByPhrase( 'ERROR' );
            } else
            {
                // else save current status
                $data['fat_status_id'] = $line->fat_status_id;
            }

            // Getting status by Fat Id
            $data['fat'] = $this->fat->actionGetFullStatusById( $data['fat_status_id'] );

            // make result of file line
            $data['file_line'] = $line->file_line;

            // collecting results to array
            $result[] = $data;
        }

        // getting results
        return $result;
    }

    /**
     * Searching errors by line
     * and update import id
     * Getting count of errors
     * @param $file_line
     * @param $update_id
     * @return mixed
     */
    protected function actionSearchErrorsByLineAndParty( $file_line, $update_id )
    {
        // allocate with restricted statuses for ERRORS
        $error = $this->fat->actionSearchStatusByPhrase( 'ERROR' );

        // getting count
        $errors = ImportLogUpdateProcessModel::where( 'file_line', $file_line )
            ->where( 'update_id', $update_id )
            ->where( 'fat_status_id', $error )
            ->count();

        return $errors;
    }

}