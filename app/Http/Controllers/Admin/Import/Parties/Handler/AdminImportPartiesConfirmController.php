<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 02.10.2016
 * Time: 20:52
 */

namespace App\Http\Controllers\Admin\Import\Parties\Handler;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesHandleInterface;
use App\Models\Import\ImportLogPartiesProcessModel;
use Illuminate\Http\Request;

/**
 * Handler for parties import procedure
 * Make for item line status APPROVED
 * To make them available for catalog
 * Class AdminImportPartiesConfirmController
 * @package App\Http\Controllers\Admin\Import\Parties\Handler
 */
class AdminImportPartiesConfirmController extends Controller implements AdminImportPartiesHandleInterface
{
    /**
     * Fat status instance
     * @var AdminImportFatStatusController
     */
    private $fat;

    /**
     * Generating fat status instance
     * AdminImportPartiesConfirmController constructor.
     * @param AdminImportFatStatusController $fat
     */
    public function __construct( AdminImportFatStatusController $fat )
    {
        $this->fat = $fat;
    }

    /**
     * Collecting data from request
     * Restrict fat statuses only for APPROVED fields
     * Updating line status to APPROVED
     * @param Request $request
     * @return bool
     */
    public function actionHandleProduct( Request $request )
    {
        $party_id = $request->input( 'party_id' );
        $file_line = $request->input( 'file_line' );
        $fat_status_id = $request->input( 'fat_status_id' );

        // search status by phrase
        $new_status = $this->fat->actionSearchStatusByPhrase( 'APPROVED' );

        try
        {
            // change exist status to new
            // as APPROVED
            ImportLogPartiesProcessModel::confirmationUpdate( $party_id, $file_line, $fat_status_id )
                ->update([
                    'fat_status_id' => $new_status,
                ]);

            // if succeed
            return true;
        } catch( \Exception $e )
        {
            // if failed
            return false;
        }
    }

}