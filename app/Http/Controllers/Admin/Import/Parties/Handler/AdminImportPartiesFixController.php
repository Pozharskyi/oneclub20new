<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 10:07
 */

namespace App\Http\Controllers\Admin\Import\Parties\Handler;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Admin\Import\Core\AdminImportLogTrait;
use App\Http\Controllers\Admin\Import\Core\AdminImportStageController;
use App\Http\Controllers\Admin\Import\Core\AdminImportSupplierTrait;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesFatDescriptionController;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesParserController;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesValidateController;
use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesHandleInterface;
use App\Models\Import\ImportLogPartiesProcessModel;
use Illuminate\Http\Request;

use DB;

// line to create new array
// based on Abstract class in Validator
const FIX_LINE = 0;

/**
 * Validate product with new FIX data
 * In order to save this
 * Getting Description based on fat
 * Getting Errors for stage
 * Creating new product with handler for stage throwable exceptions
 * Class AdminImportPartiesFixController
 * @package App\Http\Controllers\Admin\Import\Parties\Handler
 */
class AdminImportPartiesFixController extends AdminImportPartiesValidateController implements AdminImportPartiesHandleInterface
{
    use AdminImportLogTrait;
    use AdminImportSupplierTrait;

    /**
     * Import stage instance
     * @var
     */
    public $stage;

    /**
     * Party identify
     * @var
     */
    private $party_id;

    /**
     * Line identify
     * @var
     */
    private $file_line;

    /**
     * Fat status identify
     * @var
     */
    private $fat_status_id;

    /**
     * Based on request getting view to fix
     * With all information about product
     * Information got from File as well as
     * from Fat status log
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetFixView( Request $request )
    {
        // generate new description instance
        $description = new AdminImportPartiesFatDescriptionController();

        $party_id = $request->input( 'party_id' );
        $file_line = $request->input( 'file_line' );
        $fat_status_id = $request->input( 'fat_status_id' );

        // getting file description by party and file identify
        $results = $description->actionGetFileDescription( $party_id, $file_line );

        // searching for errors
        $errors = $this->actionFindErrors( $party_id, $file_line );

        // getting view
        return view('admin.import.parties.edit_fat', [
            'results' => $results,
            'party_id' => $party_id,
            'file_line' => $file_line,
            'fat_status_id' => $fat_status_id,
            'errors' => $errors,
        ]);
    }

    /**
     * Getting errors for party and line identify
     * Restrict statuses for Fat
     * Getting error messages
     * @param $party_id
     * @param $file_line
     * @return mixed
     */
    public function actionFindErrors( $party_id, $file_line )
    {
        // getting Fat status instance
        $status = new AdminImportFatStatusController();

        // getting fat status by Phrase
        $error_id = $status->actionSearchStatusByPhrase( 'ERROR' );

        // getting messages
        $info = ImportLogPartiesProcessModel::confirmationUpdate( $party_id, $file_line, $error_id )
            ->get(['message']);

        // return object of messages
        return $info;
    }

    /**
     * Handling creation of new product
     * Includes validation
     * @param Request $request
     * @return int
     */
    public function actionHandleProduct( Request $request )
    {
        $data = array();

        // initialize new stage instance
        $this->stage = new AdminImportStageController();

        $this->party_id = $request->input('party_id');
        $this->file_line = $request->input('file_line');
        $this->fat_status_id = $request->input('fat_status_id');

        // getting supplier identity
        $supplier = $this->actionSearchSupplierByParty( $this->party_id );

        // collecting information from form
        foreach( $this->import_fields as $field )
        {
            $data[$field] = $request->input( $field );
        }

        // generating array as CSV row
        $request_data = array(
            FIX_LINE => $data
        );

        // validating required fields
        $this->actionValidateFields( $this->stage, $request_data, FIX_LINE, 'required' );

        // validating warning fields
        $this->actionValidateFields( $this->stage, $request_data, FIX_LINE, 'warning' );

        // if no errors found
        if( $this->stage->actionCountStages() == 0 )
        {
            // clearing line logs
            $this->actionClearLogs( $this->file_line, $this->party_id );

            // make parser instance
            $import = new AdminImportPartiesParserController();

            // trying to generate Product
            // via Transaction
            $import->actionTryMakeImport( $data, FIX_LINE, $this->party_id, $supplier, $this->file_line );
        }

        // logging errors
        $this->actionLogImport( $this->stage, $this->file_line, $this->party_id );

        // resetting stages object
        $this->stage->actionClearStages();

        return 0;
    }

    /**
     * Forbid new method of creation
     * new Products
     */
     public function actionMakeImport(){}

}