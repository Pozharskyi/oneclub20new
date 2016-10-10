<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 22.09.2016
 * Time: 16:35
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportFileParserTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\AdminImportCreateInterface;
use App\Models\Import\ImportPartiesCategoriesModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Supplier\SupplierModel;
use App\Models\Import\ImportPartiesModel;
use App\Models\Import\ImportPartiesProcessModel;

/**
 * Parties creation handler
 * Includes creation of party, count csv,
 * getting parties creation view
 * Class AdminImportPartiesCreateController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesCreateController extends Controller implements AdminImportCreateInterface
{
    use AdminImportFileParserTrait;
    /**
     * Getting parties creation View
     * If alert exists display in UI
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetCreateView( Request $request )
    {
        $suppliers = SupplierModel::get();

        $alert = $request->input('alert');

        // if no alerts
        if( !isset( $alert ) )
        {
            $alert = null;
        }

        // getting parties types
        $parties_types = ImportPartiesCategoriesModel::get();

        return view('admin.import.parties.create', [
            'suppliers' => $suppliers,
            'alert' => $alert,
            'parties_types' => $parties_types,
        ]);
    }

    /**
     * Handler for creating of parties
     * based on request
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionCreate( Request $request )
    {
        // if no user auth getting redirect to login page
        if( !isset( Auth::user()->id ) )
        {
            return redirect('/login');
        }

        // make database transaction
        DB::beginTransaction();

        try
        {
            // creating party basic info
            $party = ImportPartiesModel::create([
                'party_name' => $request->input('party_name'),
                'supplier_id' => $request->input('supplier'),
                'party_category_id' => $request->input('party_category_id'),
                'recommended_start' => $request->input('recommended_start'),
                'recommended_end' => $request->input('recommended_end'),
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
            $fileCount = $this->actionCountCsv( $file ) - 1; // Without header, minus one line

            // getting parties process
            ImportPartiesProcessModel::create([
                'party_id' => $party->id,
                'in_process_atm' => 0,
                'in_process_total' => $fileCount,
                'file_base_path' => $file,
                'fat_status' => 'В процессе',
            ]);

            // if succeed insert into the database
            DB::commit();

        } catch( \Exception $e )
        {
            // if failed deny transaction
            DB::rollBack();

            // return bad request redirect
            return redirect('/admin/import/parties/create?alert=failed');
        }

        // return nice request redirect
        return redirect('/admin/import/parties/create?alert=success');
    }

}