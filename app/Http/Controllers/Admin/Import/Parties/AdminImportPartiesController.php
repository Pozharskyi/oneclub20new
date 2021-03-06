<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 13.10.2016
 * Time: 1:36
 */

namespace App\Http\Controllers\Admin\Import\Parties;

use App\Http\Controllers\Controller;
use App\Models\Import\ImportIndexPartiesModel;
use App\Models\Import\ImportSalesAssociationModel;

class AdminImportPartiesController extends Controller
{
    public static function actionGetAllParties( $supplierId )
    {
        $parties = ImportIndexPartiesModel::sortBySupplier( $supplierId )
            ->get(['id'])->toArray();

        return $parties;
    }

    public function actionValidatePartyForSale( $party_id, $saleInformation )
    {
        $result = array();
        $association = $this->actionGetPartyAssociation( $party_id );

        if( count( $association ) == 0 )
        {
            $result['status'] = 1;
            $result['message'] = 'Товарная партия была успешно прикреплена к товарной акции';
        } else
        {
            $validation = true;
            $failed = 0;

            $saleStart = $saleInformation->sale_start_date;
            $saleEnd = $saleInformation->sale_end_date;

            foreach( $association as $info )
            {
                if($info->sales->sale_start_date <= $saleEnd && $saleStart <= $info->sales->sale_end_date)
                {
                    $validation = false;
                    $failed = $info->import_index_sale_id;
                    break;
                }
            }

            if ($validation)
            {
                $result['status'] = 1;
                $result['message'] = 'Товарная партия была успешно прикреплена к товарной акции';
            } else
            {
                $result['status'] = 0;
                $result['message'] = 'Товарная партия не была прикреплена к товарной акции из-за ТА #' . $failed;
            }
        }

        return $result;
    }

    public function actionValidateSaleExistenceWithParty( $party_id, $sale_id )
    {
        $association = ImportSalesAssociationModel::existence($party_id, $sale_id)
            ->count();

        return $association;
    }

    private function actionGetPartyAssociation( $party_id )
    {
        $association = ImportSalesAssociationModel::where('import_index_party_id', $party_id)
            ->with(['sales'])
            ->get();

        return $association;
    }

    public static function actionFindPartiesBySupplier( $supplierId )
    {
        $parties = ImportIndexPartiesModel::sortBySupplier($supplierId)
            ->get(['id'])->toArray();

        return $parties;
    }

}