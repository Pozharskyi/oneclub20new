<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 30.09.2016
 * Time: 13:16
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Models\Import\ImportLogPartiesProcessModel;
use Illuminate\Http\Request;

/**
 * Handler for Parties Fat Description
 * Items in Request
 * Class AdminImportPartiesFatDescriptionController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesFatDescriptionController extends AdminImportPartiesFatStatusController
{
    use AdminImportPartiesFileParserTrait;
    /**
     * Getting fat instance
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Initialize fat status instance
     * AdminImportPartiesFatDescriptionController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->fat = new AdminImportFatStatusController();
    }

    /**
     * Getting Parties Fat Description View
     * based on Request
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex( Request $request )
    {
        $party_id = $request->input('party_id');
        $file_line = $request->input('file_line');

        // getting notices for party and line identifiers
        $notices = $this->actionGetNoticesForRequest( $party_id, $file_line );

        // getting description for party and line identifies
        $data = $this->actionGetFileDescription( $party_id, $file_line );

        // getting view
        return view('admin.import.parties.fat_description', [
            'notices' => $notices,
            'data' => $data,
        ]);
    }

    /**
     * Getting notices for request
     * By party and line identifiers
     * @param $party_id
     * @param $file_line
     * @return mixed
     */
    protected function actionGetNoticesForRequest( $party_id, $file_line )
    {
        // restrict statuses
        $this->fat->actionSetStatuses( 'NOTICE' );

        // getting all available statuses
        $statuses = $this->fat->actionGetStatuses();

        // getting notices
        $data = ImportLogPartiesProcessModel::search( $party_id, $file_line, $statuses )
            ->get(['fat_status_id', 'message']);

        // destroy statuses
        $this->fat->actionResetStatuses();

        return $data;
    }
}