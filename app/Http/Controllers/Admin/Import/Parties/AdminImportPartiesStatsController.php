<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.10.2016
 * Time: 12:55
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Admin\Import\Core\AdminImportSupplierTrait;
use App\Http\Controllers\Admin\Stats\AdminStatsConfigController;
use App\Http\Controllers\Admin\Stats\AdminStatsDatesParserTrait;
use App\Interfaces\Controllers\Admin\Import\AdminImportReadInterface;
use App\Interfaces\Controllers\Admin\Stats\AdminStatsInterface;
use App\Models\Order\OrderIndexSubProductModel;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

class AdminImportPartiesStatsController extends AdminStatsConfigController implements
    AdminImportReadInterface,
    AdminStatsInterface
{
    use AdminImportSupplierTrait;
    use AdminImportPartiesSuppliersTrait;

    public $partyId;
    private $subProducts;

    public function actionRead(Request $request)
    {
        $suppliers = $this->actionGetSuppliers();

        return view('admin.import.parties.stats.index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function actionGetPartyDescription($partyId, Request $request)
    {
        $this->partyId = $partyId;
        $for = $request->input('for');

        $result = array();

        $subProducts = $this->actionGetSubProductsForParty($partyId);
        $this->subProducts = $subProducts;

        foreach ($this->categories as $category) {
            $dates = $this->actionGetStatisticsDates($category);
            $data = $this->actionGetDescriptionByDates($dates->start, $dates->end);

            $result[$category] = $data;
        }

        if (isset($for)) {
            return view('admin.import.parties.stats.stats', [
                'results' => $result,
                'party_id' => $partyId,
            ]);
        } else {
            return $result;
        }
    }

    protected function actionGetSubProductsForParty($partyId)
    {
        $subProducts = SubProductModel::where('dev_import_parties_id', $partyId)
            ->get(['id'])->toArray();

        return $subProducts;
    }

    public function actionGetDescriptionByDates($start, $end = null)
    {
        $data = OrderIndexSubProductModel::dates($start, $end)
            ->whereIn('dev_sub_product_id', $this->subProducts)
            ->with(['subProduct.product'])
            ->get();

        return $data;
    }

    public function actionGetPartiesView(Request $request)
    {
        $supplierId = $request->input('supplier_id');

        $parties = $this->actionGetPartiesBySupplier($supplierId);

        return view('admin.import.parties.stats.parties', [
            'parties' => $parties,
        ]);
    }

    public function actionGetStatsView(){}

    public function actionGetDataForStatsChart(){}

}