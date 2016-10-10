<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 30.09.2016
 * Time: 17:02
 */

namespace App\Http\Controllers\Admin\Import\Core;

use App\Models\Import\ImportPartiesModel;
use App\Models\Supplier\SupplierModel;

/**
 * Main import handler for suppliers
 * Includes search by party
 * Class AdminImportSupplierTrait
 * @package App\Http\Controllers\Admin\Import\Core
 */
trait AdminImportSupplierTrait
{
    /**
     * Getting supplier id by party
     * Return object matches
     * @param $party_id
     * @return mixed
     */
    public function actionSearchSupplierByParty( $party_id )
    {
        $party = ImportPartiesModel::find( $party_id )
            ->first(['supplier_id']);

        return $party->supplier_id;
    }

    /**
     * Getting suppliers info
     * @return mixed
     */
    public function actionGetSuppliers()
    {
        $suppliers = SupplierModel::get();

        return $suppliers;
    }

}