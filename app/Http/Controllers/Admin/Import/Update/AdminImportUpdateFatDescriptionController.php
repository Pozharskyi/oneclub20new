<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 3:41
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Admin\Import\Core\AdminImportCsvParserController as CsvParser;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportLogUpdateProcessModel;
use App\Models\Import\ImportUpdateProcessModel;
use Illuminate\Http\Request;

/**
 * Getting Description of fat
 * import update
 * Includes View to get information
 * Getting notices with description of files
 * Getting parsed CSV File
 * Class AdminImportUpdateFatDescriptionController
 * @package App\Http\Controllers\Admin\Import\Update
 */
class AdminImportUpdateFatDescriptionController extends Controller
{
    use AdminImportUpdateFileParserTrait;
    /**
     * Getting Fat statuses instance
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Initialize an fat status instance
     * AdminImportUpdateFatDescriptionController constructor.
     */
    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController();
    }

    /**
     * Getting view with data
     * about each line of file
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex( Request $request )
    {
        $update_id = $request->input('update_id');
        $file_line = $request->input('file_line');

        // getting all notices for update import id
        $notices = $this->actionGetNoticesForRequest( $update_id, $file_line );

        // getting data foreach status in file
        $data = $this->actionGetFileDescription( $update_id, $file_line );

        // getting view
        return view('admin.import.parties.fat_description', [
            'notices' => $notices,
            'data' => $data,
        ]);
    }

    /**
     * Getting all notices for update identity
     * Based on Association of NOTICE party
     * @param $update_id
     * @param $file_line
     * @return mixed
     */
    protected function actionGetNoticesForRequest( $update_id, $file_line )
    {
        // restrict statuses for notices
        $this->fat->actionSetStatuses( 'NOTICE' );
        $statuses = $this->fat->actionGetStatuses();

        $data = ImportLogUpdateProcessModel::search( $update_id, $file_line, $statuses )
            ->get(['fat_status_id', 'message']);

        // resetting fat statuses object
        $this->fat->actionResetStatuses();

        return $data;
    }

}