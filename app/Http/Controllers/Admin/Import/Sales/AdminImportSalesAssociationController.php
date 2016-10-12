<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 0:39
 */

namespace App\Http\Controllers\Admin\Import\Sales;

use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesController;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportSalesAssociationLogModel;
use App\Models\Import\ImportSalesAssociationModel;
use Illuminate\Http\Request;

class AdminImportSalesAssociationController extends Controller
{
    private $message;

    private $sales;
    private $parties;

    public function __construct()
    {
        $this->parties = new AdminImportPartiesController();
        $this->sales = new AdminImportSalesController();
    }

    public function actionGetViewForAssociation()
    {
        $sales = $this->sales->actionGetAllSales();
        $parties = $this->parties->actionGetAllParties();

        return view('admin.import.sales.association', [
            'sales' => $sales,
            'parties' => $parties,
        ]);
    }

    public function actionConfirmParty(Request $request)
    {
        $party_id = $request->input('party_id');
        $sale_id = $request->input('sale_id');

        $saleInformation = $this->sales->actionGetInformationAboutSale( $sale_id );
        $validation = $this->parties->actionValidatePartyForSale( $party_id, $saleInformation );

        if( $validation['status'] == 1 )
        {
            try
            {
                ImportSalesAssociationModel::create([
                    'import_index_sale_id' => $sale_id,
                    'import_index_party_id' => $party_id,
                    'made_by' => \Auth::user()->id,
                ]);

                ImportSalesAssociationLogModel::create([
                    'import_index_sale_id' => $sale_id,
                    'import_index_party_id' => $party_id,
                    'made_by' => \Auth::user()->id,
                    'status' => 'Добавлено',
                ]);

                return view('admin.import.alert', [
                    'message' => $validation['message'],
                ]);

            } catch (\Exception $e)
            {
                return view('admin.import.alert', [
                    'message' => 'Что-то пошло не так. Попробуйте чуть позже.',
                ]);
            }
        } else
        {
            return view('admin.import.alert', [
                'message' => $validation['message'],
            ]);
        }
    }

}