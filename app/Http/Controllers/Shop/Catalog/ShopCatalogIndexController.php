<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 29.08.2016
 * Time: 14:50
 */

namespace App\Http\Controllers\Shop\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryModel;
use App\Models\Product\ProductIndexPricesModel;
use App\Models\Product\ProductPopularityModel;

use App\Models\Product\ProductSizeModel;
use App\Models\Product\ProductColorModel;

use App\Models\Product\SubProductModel;
use Illuminate\Http\Request;

/**
 * Main catalog view
 * Getting one photo, count sizes
 * And basic data
 * Class ShopCatalogIndexController
 * @package app\Http\Controllers\Shop\Catalog
 */
class ShopCatalogIndexController extends Controller
{
    /**
     * @param $shortcut
     * @param Request $request
     * @param null $order_by
     * @param null $order_sort
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex( Request $request, $shortcut = null, $order_by = NULL, $order_sort = NULL )
    {
        $router = new ShopCatalogRouterController();
        $result = $router->actionHandleCatalog( $request );

        $tree = new ShopCatalogCategoriesController();
        $categories_tree = $tree->actionGetCategoriesTree();

        if( !is_null( $order_by ) && !is_null($order_sort) )
        {
            if( $order_by == 'price' && $order_sort == 'asc' )
            {
                $by = 'special_price';
                $sort = 'ASC';
            } elseif( $order_by == 'price' && $order_sort == 'desc' )
            {
                $by = 'special_price';
                $sort = 'DESC';
            } elseif( $order_by == 'sale' && $order_sort == 'desc' )
            {
                $by = 'sale_percent';
                $sort = 'DESC';
            } else
            {
                $by = 'popularity';
                $sort = 'DESC';
            }
        } else
        {
            $by = 'popularity';
            $sort = 'DESC';
        }

        $colors = $request->input('colors');
        $sizes = $request->input('sizes');

        $min_price = $request->input('from_price');
        $max_price = $request->input('end_price');

        $category = $request->input('category');

        if (is_null($shortcut) || $shortcut == 'null') {
            if (!isset($category)) {
                $category = 'All';
            }
        } else {
            $category = $this->actionFindCategoryByShortcut($shortcut);

            if (is_null($category)) {
                return redirect('/list');
            }
        }

        $search_categories = $this->actionGetCategories( $category );

        if( $by == 'sale_percent' || $by == 'special_price' )
        {
            $collection = ProductIndexPricesModel::orderBy($by, $sort)
                ->with([
                    'subProduct' => function( $query ) use ( $colors, $sizes, $result )
                    {
                        $query->approved()
                            ->catalogItems( $result->type, $result->product_index_ids )
                            ->sizes( $sizes )
                            ->colors( $colors );
                    },
                    'subProduct.price'  => function( $query ) use ( $min_price, $max_price )
                    {
                        $query->prices( $min_price, $max_price );
                    },
                    'subProduct.product' => function( $query ) use ( $search_categories )
                    {
                        $query->categories( $search_categories );
                    },
                    'subProduct.color', 'subProduct.size',
                    'subProduct.photos', 'subProduct.product.brand',
                    'subProduct.product.description',
                ])
                ->get();
        } else
        {
            $collection = ProductPopularityModel::orderBy($by, $sort)
                ->with([
                    'subProduct' => function( $query ) use ( $colors, $sizes, $result )
                    {
                        $query->approved()
                            ->catalogItems( $result->type, $result->product_index_ids )
                            ->sizes( $sizes )
                            ->colors( $colors );
                    },
                    'subProduct.price'  => function( $query ) use ( $min_price, $max_price )
                    {
                        $query->prices( $min_price, $max_price );
                    },
                    'subProduct.product' => function( $query ) use ( $search_categories )
                    {
                        $query->categories( $search_categories );
                    },
                    'subProduct.color', 'subProduct.size',
                    'subProduct.photos', 'subProduct.product.brand',
                    'subProduct.product.description',
                ])
                ->get();
        }

        $i = 0;
        $count = count( $collection );

        while( $i < $count )
        {
            if( !isset( $collection[$i]->subProduct ) || count( $collection[$i]->subProduct ) == 0 ||
                !isset( $collection[$i]->subProduct->product->category ) || count( $collection[$i]->subProduct->product->category ) == 0 ||
                !isset( $collection[$i]->subProduct->price ) || count( $collection[$i]->subProduct->price ) == 0)
            {
                unset( $collection[$i] );
            } else
            {
                $product_id = $collection[$i]->subProduct->product->id;

                $colorsCount = SubProductModel::where('dev_product_index_id', $product_id)
                    ->groupBy('dev_product_color_id')
                    ->count();

                $collection[$i]->colorsCount = $colorsCount;

            }

            $i++;
        }

        if( !is_null( $order_by ) && !is_null( $order_sort ) )
        {
            return view('shop.catalog.sort', [
                'collection' => $collection,
                'colors' => $this->actionGetProductColors(),
                'sizes' => $this->actionGetProductSizes(),
                'qty' => count( $collection ),
                #'status' => $status,
                'results' => $categories_tree,
                'category' => $category,
            ]);
        } else
        {
            return view('shop.catalog.index', [
                'collection' => $collection,
                'colors' => $this->actionGetProductColors(),
                'sizes' => $this->actionGetProductSizes(),
                'qty' => count( $collection ),
                'route' => $result->type,
                #'status' => $status,
                'results' => $categories_tree,
                'category' => $category,
            ]);
        }
    }

    private function actionGetCategories( $category )
    {
        if( $category == 'All' )
        {
            return array();
        } else
        {
            $end = 1;
            $search = [ $category ];

            while( $end != 0 )
            {
                $categories = CategoryModel::whereIn( 'parent_id', $search )
                    ->pluck('id');

                if( count( $categories ) == 0 )
                {
                    break;
                } else
                {
                    $search = $categories;
                }
            }

            return $search;
        }
    }

    public function actionFindCategoryByShortcut( $shortcut )
    {
        $category = CategoryModel::where( 'shortcut', $shortcut )
            ->first(['id']);

        if (isset($category->id)) {
            return $category->id;
        } else {
            return false;
        }
    }

    /**
     * Getting all product colors
     * @return mixed
     */
    public function actionGetProductColors()
    {
        $data = ProductColorModel::orderBy('id')
            ->get();

        return $data;
    }

    /**
     * Getting all product sizes
     * @return mixed
     */
    public function actionGetProductSizes()
    {
        $data = ProductSizeModel::orderBy('id')
            ->get();

        return $data;
    }

}