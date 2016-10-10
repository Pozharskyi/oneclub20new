<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.08.2016
 * Time: 11:32
 */

namespace App\Http\Controllers\Admin\Notifications;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Notifications\NotificationsSequencesInterface;

use App\Models\Notifications\NotificationsParamsModel;
use App\Models\Notifications\NotificationsTypeModel;
use App\Models\Notifications\NotificationsModel;

/**
 * Getting All sequences for Event
 * Getting Sequences names
 * Getting Options foreach Type and Sequence Id
 * Class NotificationsGetSequencesController
 * @package App\Http\Controllers\Admin\Notifications
 */
class NotificationsSequencesController extends Controller implements NotificationsSequencesInterface
{
    /**
     * Getting data based on sequence type and id
     * @param $sequence_type
     * @param $sequence_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex( $sequence_type, $sequence_id ) {

        // getting all sequences
        $sequences = $this->actionGetSequences();

        // getting name for sequence
        $sequence_name = $this->actionGetSequenceName( $sequence_id );

        // getting options for Type and Id
        $options = $this->actionFindOptions( $sequence_type, $sequence_id );

        // return blade view
        return view('admin.notifications.notifications_sequences', [
            'sequences' => $sequences,
            'sequence_name' => $sequence_name,
            'options' => $options,
        ]);
    }

    /**
     * Getting Param name and Template
     * for eSputnik @service
     * @return \Illuminate\Support\Collection
     */
    public function actionGetSequences() {

        $sequences = NotificationsParamsModel::orderBy('id')
            ->get(['id', 'name', 'template_name']);

        return $sequences;
    }

    /**
     * Getting sequence name based on
     * Sequence Id
     * @param $sequence_id
     * @return \Illuminate\Support\Collection
     */
    public function actionGetSequenceName( $sequence_id )
    {
        $name = NotificationsTypeModel::where('id', '=', $sequence_id)
            ->get(['notification_type']);

        return $name;
    }

    /**
     * Getting Options based on
     * Sequence Type
     * Sequence Id
     * @param $sequence_type
     * @param $sequence_id
     * @return array|\Illuminate\Support\Collection
     */
    private function actionFindOptions( $sequence_type, $sequence_id ) {

        $sequences = NotificationsModel::where( function( $query ) use ( $sequence_type, $sequence_id )
        {
            $query->where( 'notification_id', '=', $sequence_type )
                ->where( 'notification_type_id', '=', $sequence_id );
        })->get([
            'notification_params'
        ]);

        if( empty( $sequences ) || count($sequences) == 0 )
        {
            $sequences = array();
        } else
        {
            $comma_pos = strpos(",", $sequences[0]->notification_params);

            if( $comma_pos !== false ) {
                $sequences = str_split( $sequences[0]->notification_params );
            } else {
                $sequences = explode(",", $sequences[0]->notification_params);
            }
        }

        return $sequences;
    }

}