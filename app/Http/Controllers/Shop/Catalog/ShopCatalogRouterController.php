<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 0:32
 */

namespace App\Http\Controllers\Shop\Catalog;

use App\Http\Controllers\Controller;
use App\Interfaces\Controllers\Shop\Catalog\CatalogRouterInterface;
use App\Models\Import\ImportPartiesCategoriesModel;
use App\Models\Import\ImportPartiesModel;
use App\Models\Product\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Getting information for catalog
 * based on Route
 * Two types of catalog
 * On the one hand, basic stock catalog
 * On the other hand, sales catalog
 * Class ShopCatalogRouterController
 * @package App\Http\Controllers\Shop\Catalog
 */
class ShopCatalogRouterController extends Controller implements CatalogRouterInterface
{
    /**
     * All available parties for sales
     * @var
     */
    private $salesParties;

    /**
     * Getting results for route
     * @param Request $request
     * @return \stdClass
     */
    public function actionHandleCatalog( Request $request )
    {
        $route = $request->input( 'route' );

        if( !isset( $route ) )
        {
            // getting route path
            $path = Route::getCurrentRoute()->getPath();
            $route = substr($path, 0, 4);
        }

        // getting sales parties
        $this->actionGetSalesParties();

        return $this->actionGetCategoryTypeBasedOnRoute( $route );

    }

    /**
     * Getting sales parties
     * That are active at the moment
     * @return bool
     */
    public function actionGetSalesParties()
    {
        $sale = $this->actionGetPartiesCategoryIdBasedOnType( 'Скидки' );

        $parties = ImportPartiesModel::active()
            ->where( 'party_category_id', $sale )
            ->with(['subProduct'])
            ->get();

        $result = array();

        foreach( $parties as $party )
        {
            foreach( $party->subProduct as $sub )
            {
                $result[] = $sub->dev_product_index_id;
            }
        }

        $this->salesParties = array_unique( $result );

        return true;
    }

    /**
     * Getting results based on route
     * Returning object of parties and type
     * @param $route
     * @return \stdClass
     */
    private function actionGetCategoryTypeBasedOnRoute( $route )
    {
        $result = new \stdClass();
        $result->type = $route;
        $result->product_index_ids = $this->salesParties;

        return $result;
    }

    /**
     * Getting parties category
     * Based on type name
     * @param $type
     * @return bool
     */
    private function actionGetPartiesCategoryIdBasedOnType( $type )
    {
        $info = ImportPartiesCategoriesModel::where( 'type', 'LIKE', '%' . $type . '%')
            ->first(['id']);

        if( isset( $info->id ) )
        {
            return $info->id;
        } else
        {
            return false;
        }
    }

}