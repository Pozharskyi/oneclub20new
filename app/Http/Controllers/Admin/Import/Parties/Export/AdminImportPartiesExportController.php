<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 07.10.2016
 * Time: 15:21
 */

namespace App\Http\Controllers\Admin\Import\Parties\Export;

use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesStatsController;
use App\Models\Order\OrderIndexSubProductModel;

class AdminImportPartiesExportController extends AdminImportPartiesStatsController
{
    protected function actionGetPartyCollection($partyId)
    {
        $subProducts = $this->actionGetSubProductsForParty($partyId);

        $data = OrderIndexSubProductModel::whereIn('dev_sub_product_id', $subProducts)
            ->with(['subProduct.product' => function( $query ) {
                $query->get(['sku']);
            }, 'subProduct.color' => function( $query ) {
                $query->get(['name']);
            }, 'subProduct.size' => function( $query ) {
                $query->get(['name']);
            }])
            ->get();

        $results = array();

        foreach ($data as $info) {
            $results[] = array(
                'sku' => $info->subProduct->product->sku,
                'barcode' => $info->subProduct->barcode,
                'color' => $info->subProduct->color->name,
                'size' => $info->subProduct->size->name,
                'quantity' => $info->qty,
                'price' => $info->price_for_one_product,
            );
        }

        return $results;
    }

    public function actionExportPartyForSupplier($partyId)
    {
        $collection = $this->actionGetPartyCollection($partyId);

        // :: send download headers here ::

        $out = fopen('php://output', 'w');
        fputcsv($out, array_keys($collection[1]));

        foreach ($collection as $line) {
            fputcsv($out, $line);
        }

        fclose($out);

        header('Content-Disposition: attachment; filename="export.csv"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        echo $out;

        //exit;
    }
}