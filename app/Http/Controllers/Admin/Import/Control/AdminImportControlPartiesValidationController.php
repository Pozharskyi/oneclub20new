<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 15.10.2016
 * Time: 11:45
 */

namespace App\Http\Controllers\Admin\Import\Control;

use App\Http\Controllers\Admin\Import\Statuses\AdminImportStatusesCoincidenceController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Basic\BasicBrandsTrait;
use App\Http\Controllers\Traits\Basic\BasicColorsTrait;
use App\Http\Controllers\Traits\Product\ProductCategoriesTrait;
use App\Http\Controllers\Traits\Product\ProductTrait;
use App\Http\Controllers\Admin\Import\Uploading\AdminImportUploadingAllocationController as Allocation;
use Illuminate\Http\Request;

abstract class AdminImportControlPartiesValidationController extends Controller
{
    protected $coincidenceStatus;

    use BasicColorsTrait;
    use BasicBrandsTrait;
    use ProductCategoriesTrait;
    use ProductTrait;

    public function __construct()
    {
        $this->coincidenceStatus = new AdminImportStatusesCoincidenceController;
    }

    public function actionValidateCoincidence( $fileAllocation, $import, $supplierId )
    {
        $colors = $this->actionFindColorsWithIds();
        $brands = $this->actionFindBrandsWithIds();
        $categories = $this->actionGetProductCategoriesWithIds();
        $products = $this->actionGetProducts( $supplierId );

        $partyId = Allocation::actionGetPartyByAllocation( $fileAllocation );
        $this->coincidenceStatus->actionDeleteAllocationLogs( $fileAllocation );

        $found_alert = $this->coincidenceStatus->actionFindStatusIdByPhrase('FOUND');
        $description_alert = $this->coincidenceStatus->actionFindStatusIdByPhrase('DESCRIPTION');
        $photo_alert = $this->coincidenceStatus->actionFindStatusIdByPhrase('PHOTO');
        $new_alert = $this->coincidenceStatus->actionFindStatusIdByPhrase('NEW');

        $i = 0;
        $count = count( $import );

        while( $i < $count )
        {
            $data = $import[$i];

            $product_name = $data['product_name'];
            $brand = $data['brand'];
            $color = $data['color'];

            $matchArray = array(
                'sku' => $data['sku'],
                'category_id' => $categories[$product_name],
                'brand_id' => $brands[$brand],
                'dev_product_color_id' => $colors[$color],
            );

            $newArray = array(
                'sku' => $data['description'],
            );

            $photosArray = array(
                'sku' => $data['sku'],
                'brand' => $brand,
                'color' => $color,
            );

            $matches = $this->actionGetTotalMatch($products, $matchArray, $partyId);

            if($matches)
            {
                $this->coincidenceStatus->actionLogCoincidenceStatus( $fileAllocation, $i, $found_alert );
            } else
            {
                $newMatch = $this->actionGetNewMatch($products, $newArray);

                if($newMatch)
                {
                    $this->coincidenceStatus->actionLogCoincidenceStatus( $fileAllocation, $i, $new_alert );
                } else
                {
                    $descriptionMatch = $this->actionGetDescriptionMatch($products, $newArray);
                    $photosMatch = $this->actionGetPhotosMatch( $photosArray, $fileAllocation, $i, $supplierId );

                    if(!$descriptionMatch)
                    {
                        $this->coincidenceStatus->actionLogCoincidenceStatus( $fileAllocation, $i, $description_alert );
                    }

                    if(!$photosMatch)
                    {
                        $this->coincidenceStatus->actionLogCoincidenceStatus( $fileAllocation, $i, $photo_alert );
                    }
                }
            }

            $i++;
        }

        Allocation::actionChangeAllocationStatusForDone( $fileAllocation );
    }

    abstract public function actionManageParties(Request $request);

}