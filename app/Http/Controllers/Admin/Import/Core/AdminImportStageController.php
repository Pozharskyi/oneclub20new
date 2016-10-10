<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 28.09.2016
 * Time: 15:54
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Core\AdminImportStageInterface;
use App\Models\Import\ImportFatStatusModel;

/**
 * Main Handler of Import Stages
 * Includes Pushing Stages,
 * Finding stages, force push stages,
 * Getter, Setter, Resetting of stages list
 * Class AdminImportStageController
 * @package App\Http\Controllers\Admin\Import\Core
 */
class AdminImportStageController extends Controller implements AdminImportStageInterface
{
    /**
     * Array of stages with messages list
     * @var array
     */
    protected $stages = array();

    /**
     * Pushing an fat status with the message
     * For alert
     * @param $fat_status
     * @param $stage
     */
    public function actionPushStage( $fat_status, $stage )
    {
        $push = [
            'fat_status' => $this->actionFindFatStatus( $fat_status ),
            'stage' => $stage,
        ];

        // pushing
        array_push( $this->stages, $push );
    }

    /**
     * Finding an id by phrase
     * or any collisions
     * @param $fat_status
     * @return mixed
     */
    private function actionFindFatStatus( $fat_status )
    {
        $find = ImportFatStatusModel::findStatus( $fat_status )
            ->first(['id']);

        // getting id
        return $find->id;
    }

    /**
     * If stages are empty
     * exists term for Force push and not
     * If there only errors
     * Not needle to get new stages ( for example: WARNINGS )
     * @param $fat_status
     * @param $stage
     */
    public function actionNotForcePush( $fat_status, $stage )
    {
        // if stages are empty
        if( count( $this->stages ) == 0 )
        {
            $this->actionPushStage( $fat_status, $stage );
        }
    }

    /**
     * Getting all stages with fat statuses
     * and stages messages
     * @return array
     */
    public function actionGetStages()
    {
        return $this->stages;
    }

    /**
     * Getting stages count
     * for errors
     * @return int
     */
    public function actionCountStages()
    {
        $count = 0;
        $error_id = $this->actionFindFatStatus( 'ERROR' );

        // getting count
        foreach( $this->stages as $stage )
        {
            if( $stage['fat_status'] == $error_id )
            {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Clearing all stages
     */
    public function actionClearStages()
    {
        $this->stages = array();
    }

}