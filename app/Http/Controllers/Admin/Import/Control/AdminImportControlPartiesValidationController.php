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
use Illuminate\Http\Request;

abstract class AdminImportControlPartiesValidationController extends Controller
{
    private $coincidenceStatus;
    private $request;

    use BasicColorsTrait;
    use BasicBrandsTrait;

    public function __construct(Request $request)
    {
        $this->coincidenceStatus = new AdminImportStatusesCoincidenceController;
        $this->request = $request;
    }

    public function actionValidateCoincidence( $import, $supplierId )
    {
        $colors = $this->actionFindColorsWithIds();
        $brands = $this->actionFindBrandsWithIds();

        foreach( $import as $data )
        {
            $sku = $data['sku'];

            $product_name = $data['product_name'];

            $brand = $data['brand'];
            $brand_id = $data[$brand];

            $color = $data['color'];
            $color_id = $colors[$color];
        }
    }

    abstract public function actionManageParties(Request $request);

}