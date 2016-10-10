<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 29.08.2016
 * Time: 21:54
 */

namespace App\Http\Controllers\Shop\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Shop\Catalog\ShopCatalogSearchController;

use App\Models\Shop\Basket\BasketModel;
use App\Models\Product\SubProductModel;

/**
 * Adding products to Basket
 * Class BasketAddingDataController
 * @package app\Http\Controllers\Shop\Basket
 */
class BasketAddingDataController extends Controller
{
    /**
     * Product color
     * @var
     */
    private $color;

    /**
     * Product size
     * @var
     */
    private $size;

    /**
     * Product quantity
     * @var
     */
    private $quantity;

    /**
     * Sub product parent id
     * @var
     */
    private $parent_id;

    /**
     * Current user id
     * @var
     */
    private $user_id;

    /**
     * Saving an item to the basket
     * From Http @post request
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function actionSaveIntoBasket( $id, Request $request )
    {
        /**
         * If user is auth
         */
        if( Auth::guest() )
        {
            /**
             * If user is not auth
             * @return redirect
             */
            return redirect('/login');
        } else {

            /**
             * Collecting data from form
             */
            $this->color = $request->input('color');
            $this->size = $request->input('size');
            $this->quantity = $request->input('quantity');

            $this->parent_id = $id;
            $this->user_id = Auth::user()->id;

            /**
             * Searching an sub product
             * From @parent id
             */
            $sub_product = SubProductModel::where('dev_product_index_id', $this->parent_id)
                ->where('dev_product_size_id', $this->size )
                ->where('dev_product_color_id', $this->color )
                ->first(['id', 'quantity']);

            $this->actionValidateIfProductAvailable( $sub_product );

            /**
             * If product exists
             */
            $in_basket = $this->actionFindIfProductInBasket( $sub_product->id );

            if( $in_basket !== false )
            {
                /**
                 * Update quantity
                 */
                $this->actionUpdateProduct( $in_basket );
            } else
            {
                /**
                 * Save new product
                 */
                $this->actionSaveProduct( $sub_product->id );
            }

            /**
             * @return redirect
             */
            return redirect('/basket');
        }
    }

    /**
     * Searching if the product
     * exists in basket
     * @param $sub_product
     * @return bool
     */
    private function actionFindIfProductInBasket( $sub_product )
    {
        $field = BasketModel::where('user_id', '=', $this->user_id)
            ->where('sub_product_id', '=', $sub_product)
            ->first(['id']);

        if( count( $field ) != 0 )
        {
            return $field->id;
        } else
        {
            return false;
        }
    }

    /**
     * Update existing product
     * with Quantity
     * @param $basket_id
     */
    private function actionUpdateProduct( $basket_id ) {

        $item = BasketModel::find( $basket_id );

        $item->sub_product_quantity += $this->quantity;

        $item->save();
    }

    /**
     * Inserting new product
     * to the Basket
     * @param $sub_product
     */
    private function actionSaveProduct( $sub_product )
    {
        BasketModel::create([
            'user_id' => $this->user_id,
            'sub_product_id' => $sub_product,
            'sub_product_quantity' => $this->quantity,
        ]);
    }

    /**
     * Validating if product if available
     * And not reserved
     * By sub product id
     * @param $sub_product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|int
     */
    private function actionValidateIfProductAvailable( $sub_product )
    {
        $reserved = ShopCatalogSearchController::actionFindReservedQuantityForSubProduct( $sub_product->id );
        $available = $sub_product->quantity - $reserved;

        if( $sub_product->quantity == 0 )
        {
            return redirect('/basket/?error=product_bought&available=0&reserved=0');
        } elseif( $this->quantity > $available )
        {
            return redirect('/basket?error=product_reserved&available=' . $available . '&reserved=' . $reserved);
        }

        return 0;
    }

    /**
     * Validating if product can increase by 1
     * for basket
     * @param $basket_id
     * @param $product_quantity
     * @return string
     */
    public function actionValidateIfProductInBasketCanIncrease( $basket_id, $product_quantity )
    {
        $sub_product = BasketModel::with(['subProduct'])
            ->where( 'id', $basket_id )
            ->first();

        $reserved = ShopCatalogSearchController::actionFindReservedQuantityForSubProduct( $sub_product->subProduct->id, $sub_product->user_id );
        $available = $sub_product->subProduct->quantity - $reserved;

        $needle = $product_quantity + 1;

        if( $needle <= $available )
        {
            return 'true';
        } else
        {
            return '&available=' . $available;
        }
    }

}