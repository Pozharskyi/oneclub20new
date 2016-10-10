<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 03.10.2016
 * Time: 18:02
 */

namespace App\Interfaces\Controllers\Admin\Import\Parties;

use Illuminate\Http\Request;

/**
 * Includes the main method of finding product
 * There two ways to find
 * First, by sku ( attribute )
 * Second, by barcode ( attribute )
 * Interface AdminImportPartiesSearchInterface
 * @package App\Interfaces\Controllers\Admin\Import\Parties
 */
interface AdminImportPartiesSearchInterface
{
    /**
     * Finding product
     * by unique barcode
     * @param Request $request
     * @return mixed
     */
    public function actionSearchByBarcode( Request $request );

    /**
     * Finding product
     * by unique sku
     * @param Request $request
     * @return mixed
     */
    public function actionSearchBySku( Request $request );

}