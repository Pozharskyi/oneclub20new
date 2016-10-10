<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 09.10.2016
 * Time: 19:49
 */

namespace App\Http\Controllers\Admin\Import\Share;

use App\Http\Controllers\Admin\Import\Core\AdminImportFatStatusController;
use App\Http\Controllers\Controller;
use App\Models\Import\ImportLogPartiesProcessModel as Process;
use App\Models\Import\ImportSalesAssociationModel;
use App\Models\Import\ImportSalesShareModel;
use App\Models\Order\OrderIndexSubProductModel;
use App\Models\Order\OrderStatusModel;
use App\Models\Product\SubProductModel;

class AdminImportShareStatsController extends Controller
{
    private $fat;

    private $total = array();
    private $brands = array();

    public function __construct()
    {
        $this->fat = new AdminImportFatStatusController;

        $this->total = array(
            'total_products' => 0,
            'found_products' => 0,
            'total_price' => 0,
            'average_price' => 0,
            'total_marga' => 0,
            'average_marga' => 0,
            'average_sale' => 0,
            'total_order' => 0,
            'total_order_paid' => 0,
            'brands' => array(),

            'count_iterates' => 0,
        );
    }

    public function actionGetStatsView($shareId)
    {
        $description = $this->actionGetShareDescription($shareId);
        $info = $this->actionGetStockDescription($shareId);

        $this->actionHandleTotalStats();

        return view('admin.import.share.stats', [
            'description' => $description,
            'info' => $info,

            'total' => $this->total,
            'brands' => $this->brands,
        ]);
    }

    public function actionGetShareDescription($shareId)
    {
        $description = ImportSalesShareModel::with(['user'])
            ->findOrFail($shareId);

        return $description;
    }

    public function actionGetPartiesForSale($shareId)
    {
        $parties = ImportSalesAssociationModel::where('share_id', $shareId)
            ->with(['party'])
            ->get(['party_id']);

        return $parties;
    }

    private function actionGetTotalSum($partyId)
    {
        $stock = SubProductModel::where('dev_import_parties_id', $partyId)
            ->with(['price'])
            ->get();

        $total = 0;
        $totalMarga = 0;
        $sale = 0;

        $count = count($stock);

        foreach ($stock as $products) {
            $total += $products->price->special_price;
            $totalMarga += $products->price->product_marga;
            $sale += $products->price->sale_percent;
        }

        $average = round($total / $count, 2);
        $averageMarga = round($totalMarga / $count, 2);
        $averageSale = round($sale / $count, 2);

        $result = new \stdClass();
        $result->total = $total;
        $result->average = $average;
        $result->marga = $totalMarga;
        $result->averageMarga = $averageMarga;
        $result->averageSale = $averageSale;

        return $result;
    }

    protected function actionGetSubProductsForParty($partyId)
    {
        $subProducts = SubProductModel::where('dev_import_parties_id', $partyId)
            ->get(['id'])->toArray();

        return $subProducts;
    }

    public function actionGetPartiesStatsForBrands($partyId)
    {
        $subProducts = $this->actionGetSubProductsForParty($partyId);

        $data = SubProductModel::approved()
            ->whereIn('id', $subProducts)
            ->with(['product', 'product.brand'])
            ->get();

        $result = array();

        foreach ($data as $info) {
            $brand = $info->product->brand->brand_name;

            if (!isset($result[$brand])) {
                $result[$brand] = array();
            }

            array_push($result[$brand], $info->id);
        }

        $paidStatus = $this->actionGetPaidProductStatus();
        $brands = array();

        foreach ($result as $brand => $subProducts) {
            $order = OrderIndexSubProductModel::whereIn('dev_sub_product_id', $subProducts)
                ->get();

            $totalOrdered = 0;
            $totalOrderedPaid = 0;

            $totalPrice = 0;
            $totalPaid = 0;

            foreach ($order as $info) {
                $totalOrdered++;
                $totalPrice += $info->price_for_one_product;

                if ($info->dev_order_status_list_id == $paidStatus) {
                    $totalOrderedPaid++;
                    $totalPaid += $info->price_for_one_product;
                }
            }

            $count = count($result[$brand]);

            $brands[] = array(
                'brand' => $brand,
                'count' => $count,
                'totalOrdered' => $totalOrdered,
                'totalOrderedPaid' => $totalOrderedPaid,
                'totalPrice' => $totalPrice,
                'totalPaid' => $totalPaid,
            );

            if (!isset($this->brands[$brand])) {
                $this->brands[$brand] = array(
                    'count' => 0,
                    'totalOrdered' => 0,
                    'totalOrderedPaid' => 0,
                    'totalPrice' => 0,
                    'totalPaid' => 0,
                    'count_iterates' => 0,
                );
            }

            $this->brands[$brand]['count'] += $count;
            $this->brands[$brand]['totalOrdered'] += $totalOrdered;
            $this->brands[$brand]['totalOrderedPaid'] += $totalOrderedPaid;
            $this->brands[$brand]['totalPrice'] += $totalPrice;
            $this->brands[$brand]['totalPaid'] += $totalPaid;
            $this->brands[$brand]['count_iterates']++;
        }

        return $brands;
    }

    public function actionGetPaidProductStatus()
    {
        $paidStatus = OrderStatusModel::where('admin_status', 'LIKE', '%Доставлен и оплачен%')
            ->first(['id']);

        return $paidStatus->id;
    }

    public function actionGetOrderTotalPriceForParty($partyId)
    {
        $subProducts = $this->actionGetSubProductsForParty($partyId);

        $data = OrderIndexSubProductModel::whereIn('dev_sub_product_id', $subProducts)
            ->with(['subProduct.price'])
            ->get();

        $total = 0;
        $totalPaid = 0;

        $paidStatus = $this->actionGetPaidProductStatus();

        foreach ($data as $info) {
            $total += $info->price_for_one_product;

            if ($info->dev_order_status_list_id == $paidStatus) {
                $totalPaid += $info->price_for_one_product;
            }
        }

        $info = new \stdClass();
        $info->total = $total;
        $info->totalPaid = $totalPaid;

        return $info;
    }

    public function actionGetStockDescription($shareId)
    {
        $parties = $this->actionGetPartiesForSale($shareId);

        $approvedStatus = $this->fat->actionSearchStatusByPhrase('APPROVED');

        $foundInHis = $this->fat->actionSearchStatusByPhrase('OWN_FOUND');
        $foundInAnother = $this->fat->actionSearchStatusByPhrase('ANOTHER_FOUND');

        $founds = array($foundInHis, $foundInAnother);

        $description = array();

        foreach ($parties as $party) {
            $total = Process::where('fat_status_id', $approvedStatus)
                ->where('party_id', $party->party_id)
                ->count();

            $simple = Process::status($party->party_id, $founds)
                ->count();

            $prices = $this->actionGetTotalSum($party->party_id);
            $totalOrder = $this->actionGetOrderTotalPriceForParty($party->party_id);
            $brands = $this->actionGetPartiesStatsForBrands($party->party_id);

            $description[$party->party->party_name] = array(
                'party_id' => $party->party->id,
                'total_products' => $total,
                'found_products' => $simple,
                'total_price' => $prices->total,
                'average_price' => $prices->average,
                'total_marga' => $prices->marga,
                'average_marga' => $prices->averageMarga,
                'average_sale' => $prices->averageSale,
                'total_order' => $totalOrder->total,
                'total_order_paid' => $totalOrder->totalPaid,
                'brands' => $brands,
            );

            $this->total['total_products'] += $total;
            $this->total['found_products'] += $simple;
            $this->total['total_price'] += $prices->total;
            $this->total['average_price'] += $prices->average;
            $this->total['total_marga'] += $prices->marga;
            $this->total['average_marga'] += $prices->averageMarga;
            $this->total['average_sale'] += $prices->averageSale;
            $this->total['total_order'] += $totalOrder->total;
            $this->total['total_order_paid'] += $totalOrder->totalPaid;

            $this->total['count_iterates']++;
        }

        return $description;
    }

    private function actionHandleTotalStats()
    {
        $this->total['average_price'] = round($this->total['average_price'] / $this->total['count_iterates'], 2);
        $this->total['average_marga'] = round($this->total['average_marga'] / $this->total['count_iterates'], 2);
        $this->total['average_sale'] = round($this->total['average_sale'] / $this->total['count_iterates'], 2);
    }
}