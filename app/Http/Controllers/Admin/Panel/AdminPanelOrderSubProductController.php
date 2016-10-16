<?php


namespace App\Http\Controllers\Admin\Panel;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Shop\Catalog\ShopCatalogDescriptionController;
use App\Http\Controllers\Shop\Catalog\ShopCatalogReserveController;
use App\Models\Order\OrderModel;
use App\Models\Product\ProductColorModel;
use App\Models\Product\ProductModel;
use App\Models\Product\ProductPopularityModel;
use App\Models\Product\SubProductModel;
use App\Models\SizeChart\SizeChartModel;
use Illuminate\Http\Request;

class AdminPanelOrderSubProductController extends Controller
{
    public function getViewSubProduct(Request $request, $userId, $orderId)
    {
        $product_store_id = $request->searchString;

        $product_id = ProductModel::where('product_store_id', $product_store_id)->pluck('id')->first();
        if(!$product_id){
            \Session::flash('message', 'Не верный № продукта');
            return redirect()->back();
        }
//        dd($product_id);
        $colorIds =  SubProductModel::where('dev_product_index_id', $product_id)->distinct()->pluck('dev_product_color_id');
//        dd($colorIds);
        $color_id = $colorIds->first();
//        ProductColorModel::whereIn('id', $colorIds)->get(['id', 'name']);

        $view = $this->actionIndex( $product_store_id, $color_id , $userId, $orderId);
        return $view;
    }


    /**
     * Getting basic description
     * @param $product_store_id
     * @param $color_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actionIndex( $product_store_id, $color_id, $userId, $orderId )
    {
        $this->actionUpdatePopularity( $product_store_id, $color_id );
        $product = $this->actionFindProductIdByStoreId( $product_store_id );
        $sizes = $this->actionGetSizesForProductByColor( $product->id, $color_id );

        $collection = ProductModel::with([
            'brand', 'description', 'subProducts.price',
            'subProducts.color', 'subProducts.size', 'subProducts.photos'
        ])->findOrFail( $product->id );

        $data = new \stdClass;
        $data->id = $collection->id;

        $reserve = ShopCatalogReserveController::actionCheckProductAvailability( array(
            '0' => $data
        ));

//        $estimated_delivery_timestamp = strtotime( date('Y-m-d') . " +" . $collection->description->product_delivery_days . " days" );
//        $estimated_delivery_date = date( 'Y-m-d', $estimated_delivery_timestamp );

        //var_dump( $collection->subProducts[0]->price[0]->final_price );

        //START SECTION SIZE_CHART

        //TODO fetch product one time with all needed fields
        $productEntity = ProductModel::where('id', $product->id)->first(['brand_id', 'category_id']);
        $sizeCharts = SizeChartModel::with(['measurements.name', 'size'])
            ->where('brand_id', $productEntity->brand_id)
            ->where('category_id', $productEntity->category_id)
            ->get();
        //END SECTION SIZE_CHART

        $publicOrderId = OrderModel::where('id', $orderId)->firstOrFail(['public_order_id']);
        return view('admin.panel.subproducts.show', [
            'collection' => $collection,
            'product_photo' => $collection->subProducts[0]->photos[0]->photo,
            'product_id' => $product->id,
//            'estimated_delivery_date' => $estimated_delivery_date,

            'color_id' => $color_id,
            'sizes' => $sizes,

            'reserve' => $reserve,

            'sizeCharts' => $sizeCharts,

            'userId' =>$userId,
            'orderId' => $orderId,
            'publicOrderId' => $publicOrderId->public_order_id,
        ]);
    }

    public static function actionGetSizesForProductByColor( $product_id, $color_id )
    {
        $data = SubProductModel::where( 'dev_product_index_id', $product_id )
            ->where( 'dev_product_color_id', $color_id )
            ->with(['size'])
            ->get();

        return $data;
    }

    /**
     * Updating product popularity
     * @param $product_store_id
     * @param $color_id
     */
    private function actionUpdatePopularity( $product_store_id, $color_id )
    {
        $product = $this->actionFindProductIdByStoreId( $product_store_id );
        $subProduct = $this->actionGetSubProductByColorAndProduct( $product->id, $color_id );
        $popularity = $this->actionFindPopularityRow( $subProduct->id );

        $model = ProductPopularityModel::find( $popularity->id );

        $model->popularity += 1;

        $model->save();
    }

    /**
     * Getting product id
     * from public store id
     * @param $product_store_id
     * @return mixed
     */
    private function actionFindProductIdByStoreId( $product_store_id )
    {
        return ProductModel::where( 'product_store_id', $product_store_id )
            ->first(['id']);
    }

    private function actionGetSubProductByColorAndProduct( $product_id, $color_id )
    {
        return SubProductModel::where( 'dev_product_index_id', $product_id )
            ->where( 'dev_product_color_id', $color_id )
            ->first(['id']);
    }

    /**
     * Getting popularity row
     * from product
     * @param $product_id
     * @return mixed
     */
    private function actionFindPopularityRow( $product_id )
    {
        return ProductPopularityModel::where( 'sub_product_id', $product_id )
            ->first(['id']);
    }
}