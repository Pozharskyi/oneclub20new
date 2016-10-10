<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 14:15
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Admin\Import\Core\AdminImportSubProductTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesDescriptionInterface;
use App\Models\Import\ImportLogPartiesProcessModel;
use App\Models\Import\ImportPartiesModel;
use DB;

/**
 * Getting parties description
 * Handle for party info with allocation
 * Fat information to handle
 * Class AdminImportPartiesDescriptionController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesDescriptionController extends Controller implements AdminImportPartiesDescriptionInterface
{
    use AdminImportSubProductTrait;
    /**
     * Getting party description
     * based on party identify
     * @param $party_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionGetPartyDescription( $party_id )
    {
        // getting info about party
        $info = $this->actionGetPartyInfo( $party_id );

        // getting fat info about party
        $fat = $this->actionGetFatInfo( $party_id );

        // getting products in party
        $products = $this->actionGetProducts( $party_id );

        // count percent of succeed
        $succeed = round( ($info->partiesProcess->in_process_atm / $info->partiesProcess->in_process_total) * 100, 2 );

        // getting view
        return view('admin.import.parties.description', [
            'info' => $info,
            'succeed' => $succeed,
            'fat' => $fat,
            'products' => $products,
        ]);
    }

    /**
     * Getting party info based on
     * party identify
     * @param $party_id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function actionGetPartyInfo( $party_id )
    {
        $info = ImportPartiesModel::with([
                'supplier', 'user',
                'partiesCategory', 'partiesProcess',
            ])->findOrFail( $party_id );

        return $info;
    }

    /**
     * Getting file allocation table information
     * With grouping as total
     * @param $party_id
     * @return mixed
     */
    public function actionGetFatInfo( $party_id )
    {
        $fat = new AdminImportFatStatusController();
        $code_error = $fat->actionSearchStatusByPhrase( 'SYSTEM_ERROR' );

        $info = ImportLogPartiesProcessModel::where( 'party_id', $party_id )
            ->where( 'fat_status_id', '<>', $code_error )
            ->with(['fat'])
            ->groupBy('fat_status_id')
            ->select('fat_status_id', DB::raw('count(*) as total'))
            ->get();

        return $info;
    }

}