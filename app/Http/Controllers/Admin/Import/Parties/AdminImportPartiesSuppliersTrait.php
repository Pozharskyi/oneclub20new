<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 26.09.2016
 * Time: 12:12
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Models\Import\ImportPartiesModel;

/**
 * Handler for parties suppliers
 * Includes getting all suppliers and
 * getting party supplier
 * Class AdminImportPartiesSuppliersTrait
 * @package App\Http\Controllers\Admin\Import\Parties
 */
trait AdminImportPartiesSuppliersTrait
{
    /**
     * Getting all parties
     * suppliers
     * @return mixed
     */
    public function actionGetAllPartiesSuppliers()
    {
        $users = ImportPartiesModel::groupBy( 'supplier_id' )
            ->with(['supplier'])
            ->get();

        return $users;
    }

    /**
     * Getting party suplier
     * Based on party identify
     * @param $party_id
     * @return mixed
     */
    public function actionGetPartySupplier( $party_id )
    {
        $supplier = ImportPartiesModel::find( $party_id )
            ->first(['id']);

        return $supplier->id;
    }

    public function actionGetPartiesBySupplier($supplierId)
    {
        $parties = ImportPartiesModel::where( 'supplier_id', $supplierId )
            ->get(['id', 'party_name']);

        return $parties;
    }

}