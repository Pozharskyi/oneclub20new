<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 16:07
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Admin\Import\Parties\AdminImportPartiesSearchInterface;
use App\Models\Product\ProductModel;
use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

/**
 * Getting parties search description
 * Based on Request
 * Two methods are available: by sky or barcode
 * Class AdminImportPartiesDescriptionSearchController
 * @package App\Http\Controllers\Admin\Import\Parties
 */
class AdminImportPartiesDescriptionSearchController extends Controller implements AdminImportPartiesSearchInterface
{
    /**
     * Searching sub product by barcode
     * Getting count of products
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearchByBarcode( Request $request )
    {
        $barcode = $request->input('barcode');

        // getting products information
        $products = SubProductModel::where( 'barcode', 'LIKE', '%' . $barcode . '%' )
            ->with(['product', 'price', 'color', 'size', 'photos'])
            ->get();

        // getting products count
        $count = count( $products );

        // getting view
        return view('admin.import.parties.searchByBarcode', [
            'products' => $products,
            'count' => $count,
        ]);
    }

    /**
     * Searching sub product by sku
     * Getting count for products
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionSearchBySku( Request $request )
    {
        $sku = $request->input('sku');

        // getting products
        $products = ProductModel::where( 'sku', 'LIKE', '%' . $sku . '%' )
            ->with([
                'subProducts', 'subProducts.price', 'subProducts.color',
                'subProducts.size', 'subProducts.photos'
            ])->get();

        // getting products count
        $count = count( $products );

        // getting view
        return view('admin.import.parties.searchBySku', [
            'products' => $products,
            'count' => $count,
        ]);
    }

}