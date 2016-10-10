<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 27.09.2016
 * Time: 17:03
 */

namespace App\Http\Controllers\Admin\Import\Update;

use App\Http\Controllers\Admin\Import\Core\AdminImportFileParserTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Import\ImportUpdateModel;
use App\Models\Import\ImportUpdateProcessModel;
use DB;

/**
 * Creation of update party
 * Includes view, form, counter of
 * Csv file format
 * Class AdminImportUpdateCreateController
 * @package App\Http\Controllers\Admin\Import\Update
 */
class AdminImportUpdateCreateController extends Controller implements AdminImportCreateInterface
{
    use AdminImportFileParserTrait;
    /**
     * Getting view for creation
     * for update parties
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetCreateView( Request $request )
    {
        // if any message in headers
        $alert = $request->input('alert');

        if( !isset( $alert ) )
        {
            $alert = null;
        }

        // getting view with alert
        return view('admin.import.update.create', [
            'alert' => $alert,
        ]);
    }

    /**
     * Creation of update party
     * If no user auth make redirect for Auth page
     * else trying to make new update party
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionCreate( Request $request )
    {
        // if no user auth
        if( !isset( Auth::user()->id ) )
        {
            // getting redirect
            return redirect('/login');
        }

        // making request as transaction
        DB::beginTransaction();

        try
        {
            // creating base update party
            // with similar information
            $update = ImportUpdateModel::create([
                'update_name' => $request->input('party_name'),
                'recommended_start' => $request->input('recommended_start'),
                'made_by' => Auth::user()->id,
            ]);

            $input = $request->file('import');

            // SET UPLOAD PATH
            $destinationPath = 'uploads';

            // GET THE FILE EXTENSION
            $extension = $input->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = date('Y-m-d') . 'V' . date('His') . '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $input->move($destinationPath, $fileName);

            $file = $destinationPath . '/' . $fileName;
            $fileCount = $this->actionCountCsv( $file ) - 1; // DUE TO HEADER

            // creating handler to proceed update parties
            ImportUpdateProcessModel::create([
                'update_id' => $update->id,
                'in_process_atm' => 0,
                'in_process_total' => $fileCount,
                'file_base_path' => $file,
                'fat_status' => 'В процессе',
            ]);

            // if succeed insert into the db
            DB::commit();

        } catch( \Exception $e )
        {
            // if error rollBack database
            DB::rollBack();

            // return redirect with failed message
            return redirect('/admin/import/update/create?alert=failed');
        }

        // return redirect with success message
        return redirect('/admin/import/update/create?alert=success');
    }
}