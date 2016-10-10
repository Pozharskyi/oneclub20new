<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 04.10.2016
 * Time: 1:38
 */

namespace App\Interfaces\Controllers\Shop\Catalog;

/**
 * Getting all information about parties
 * That are active for sales
 * And not are in catalog
 * Interface CatalogRouterInterface
 * @package App\Interfaces\Controllers\Shop\Catalog
 */
interface CatalogRouterInterface
{
    /**
     * Getting all parties for sale
     * that are active
     * @return mixed
     */
    public function actionGetSalesParties();

}