<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'IndexController@actionIndex');

Route::get('/home', 'HomeController@index');

Route::post('login', 'Auth\AuthController@login');
Route::get('/login', 'Auth\AuthorizationController@index');

Route::get('/register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

/**
 * Route @for Collecting data
 * from Social Provider
 * and @redirect to Continue collecting fields
 * like Email, password
 */
Route::get('/social/{provider}', [ 'uses' => 'Auth\Social\SocialStepsContinueController@getProviderData' ])
    ->where(['provider' => '[A-Za-z]+']);

/**
 * Get information about tracking
 * with NovaPoshta Api
 */
Route::get('/delivery/nova_poshta/tracking/{order_id}', [ 'uses' => 'Delivery\Novaposhta\NPTrackingController@actionGetTrackingData' ])
    ->where(['order_id' => '[A-Za-z1-9]+']);

/**
 * Getting TTN
 * by request
 */
Route::get('/delivery/nova_poshta/get_ttn', 'Delivery\Novaposhta\NPInternetDocumentController@actionGetInternetDocument');

/**
 * Getting NP cities
 * Names
 */
Route::get('/delivery/nova_poshta/cities', 'Delivery\Novaposhta\NPDeliveryPointsController@actionGetNPCities');

/**
 * Getting Delivery Points
 * By city param
 * For Nova Poshta
 */
Route::get('/delivery/nova_poshta/delivery_points/{city_id}', [ 'uses' => 'Delivery\Novaposhta\NPDeliveryPointsController@actionGetDeliveryPointsByCity' ]);

/** NOTIFICATIONS AREA */

Route::group(['prefix' => 'admin/notifications'], function()
{
    /**
     * Getting notifications Admin
     * @main page for control
     */
    Route::get('', 'Admin\Notifications\NotificationsIndexController@actionIndex');

    /**
     * Getting All options for an event
     * based on id
     * @param $event_id
     */
    Route::get('/list/{event_id}', [ 'uses' => 'Admin\Notifications\NotificationsOptionsController@actionIndex' ])
        ->where(['event_id' => '[1-9]+']);

    /**
     * Getting all sequences
     * @param $sequence_type
     * $param $sequence_id
     */
    Route::get('/options/{sequence_type}/{sequence_id}', [ 'uses' => 'Admin\Notifications\NotificationsSequencesController@actionIndex' ])
        ->where(['sequence_type' => '[1-9]+'])
        ->where(['sequence_id' => '[1-9]+']);

    /**
     * Getting data for user
     * based on method
     * @param $method
     * @param $user_id
     */
    Route::get('/info/{method}/{user_id}', [ 'uses' => 'Admin\Notifications\NotificationsMethodController@actionIndex' ])
        ->where(['method' => '[a-zA-Z]+'])
        ->where(['user_id' => '[1-9]+']);

    /**
     * Saving an notification
     */
    Route::get('/save', 'Admin\Notifications\NotificationsSaveController@actionIndex');
});

/** END NOTIFICATIONS AREA */

/** START NOTIFICATIONS AREA */

Route::group(['prefix' => '/notifications'], function()
{
    /**
     * Default sending SMS
     * Basic
     * @IMPORTANT added only for development,
     * @not production
     */
    Route::get('/sms', 'Notifications\ESputnik\NotificationsMessageController@actionSendMessage');

    /**
     * Default sending email
     * Basic
     * @IMPORTANT added only for development,
     * @not production
     */
    Route::get('/email', 'Notification\ESputnik\NotificationsEmailController@actionSendEmail');

    /**
     * Basic index for sending @to user
     * Emails and messages
     * With content associated remotely in eSputnik
     * @variable user_id | id of user
     * @variable type | email or phone
     * @variable content_id | id of email or phone message in eSputnik
     */
    Route::get('/{user_id}/{trigger_id}', [ 'uses' => 'Notifications\ESputnik\NotificationsIndexController@actionSendMessage' ])
        ->where(['user_id' => '[1-9]+'])
        ->where(['trigger_id' => '[1-9]+']);

});

/** START CATALOG INDEX */

Route::get('/list/{category?}', 'Shop\Catalog\ShopCatalogIndexController@actionIndex');

/** END CATALOG INDEX */

/*
 *  Route to receive messages from the payment systems
 * @incoming get[pay_system] - name payment system
 */
Route::match(['get', 'post'],'/payments_check/{pay_system}',['uses'=>'Payments\Receive\PaymentsReceiveController@actionIndex']);
/*
 *  end report payments ares
 */
Route::get('test_form_liqpay', 'Payments\Receive\TestFormPaymentsReceiveLiqpay@actionIndex');


/**
 * User cabinet
 */

Route::group(['prefix'=>'cabinet','namespace'=>'User\Cabinet'], function(){
    /**********
     * Default route
     */
    Route::get('','UserInfoController@ActionIndex');

    /**********
     *  View list user orders
     */
    Route::get('orders','UserOrdersController@ActionIndex');
    /*
     * View details and list products user's order's
     */
    Route::get('orders/{order_id}','UserOrdersController@orderDetails');
    /*
     * Delete product on user order
     */
    #Route::put('orders/{order_id}','UserOrdersController@cancelUserOrder');

    /**********
     * View list user bonus
     */
    Route::get('bonus','UserBonusController@ActionIndex');

    /**********
     * View list user subscribations
     */
    Route::get('subscribations','UserSubscribationController@ActionIndex');
    /*
     * Update user subscribations
     */
    Route::put('subscribations','UserSubscribationController@updateUserSubscribations');

    /**********
     * View user info
     */
    Route::get('my_info','UserInfoController@ActionIndex');
    /*
     * Update user info
     */
    Route::put('my_info','UserInfoController@updateUserInfo');
});

/** INDEX CATALOG AREA */

/**
 * Getting basic catalog View
 */

Route::group(['prefix' => '/list'], function()
{
    Route::get('', 'Shop\Catalog\ShopCatalogIndexController@actionIndex');
    /**
     * Getting product description page
     * @param $product_store_id
     */
    Route::get('/{product_store_id}/{color_id}', 'Shop\Catalog\ShopCatalogDescriptionController@actionIndex');

    Route::put('/find/sizes/{product_id}/{color_id}', 'Shop\Catalog\ShopCatalogSearchController@actionGetSizesForProductByColor')
        ->where([
            'product_id' => '[1-9]+',
            'color_id' => '[1-9]+',
        ]);

    Route::put('/find/quantity/{product_id}/{color_id}/{size_id}', 'Shop\Catalog\ShopCatalogSearchController@actionGetQuantityForProduct')
        ->where([
            'product_id' => '[1-9]+',
            'color_id' => '[1-9]+',
            'size_id' => '[1-9]+',
        ]);

    Route::put('/validate/{basket_id}/{product_quantity}', 'Shop\Basket\BasketAddingDataController@actionValidateIfProductInBasketCanIncrease')
        ->where([
            'sub_product' => '[1-9]+',
            'product_quantity' => '[1-9]+',
        ]);

    Route::post('/reserve/item/{basket_id}', 'Shop\Basket\BasketReserveBackController@actionReserveBack');

    Route::put('/reserve/validation/{user_id}', 'Shop\Checkout\CheckoutProductValidationController@actionCheckProductsForCheckout')
        ->where([
            'user_id' => '[1-9]+',
        ]);

    /** END INDEX CATALOG AREA */

    /** INDEX BASKET AREA */

    /**
     * Saving into basket
     */
    Route::post('/save/{id}', 'Shop\Basket\BasketAddingDataController@actionSaveIntoBasket')
        ->where(['id' => '[1-9]+']);

    /**
     * Deleting from basket
     */
    Route::delete('/save/{id}', 'Shop\Basket\BasketDeleteDataController@actionDeleteFromBasket')
        ->where(['id' => '[1-9]+']);

    /**
     * Changing quantity of items
     */
    Route::post('/change/{basket_id}', 'Shop\Basket\BasketChangeQuantityController@actionChangeQuantity')
        ->where([ 'basket_id' => '[1-9]+' ]);
});

Route::get('/sale/{category?}', 'Shop\Catalog\ShopCatalogIndexController@actionIndex');
Route::post('/sort/{shortcut}/{order_by}/{order_sort}', 'Shop\Catalog\ShopCatalogIndexController@actionIndex');

/**
 * Getting basket
 */
Route::get('/basket', 'Shop\Basket\BasketIndexController@actionIndex');

Route::post('/checkout/conflict/{user_id}', 'Shop\Checkout\CheckoutConflictResolveController@actionResolveConflict')
    ->where(['user_id' => '[1-9]+']);

/** END INDEX CATALOG AREA */

/** CHECKOUT AREA */

Route::get('/checkout', 'Shop\Checkout\CheckoutIndexController@actionIndex');

/** END CHECKOUT AREA */

/** BASKET AREA */

/**
 * Getting timers
 */
Route::get('/basket/timers', 'Shop\Basket\BasketTimerController@actionIndex');

/** END INDEX BASKET AREA */

/** DISCOUNTS */

/**
 * Getting data about discount in
 * checkout view
 */
Route::put('/list/discounts', 'Shop\Basic\DiscountsController@getDiscountAmountByCoupon');

Route::post('/list/auto_discount', 'Shop\Basic\DiscountsController@actionGetAutoDiscount');


/** END DISCOUNTS */

/**
 * Routing for saving an order
 */
Route::post('/list/order/save', 'Shop\Order\OrderController@actionSaveOrder');

/** START ADMIN PANEL AREA */
//Route::group(['middleware' => ['auth','admin']], function () {
    Route::group(['prefix' => '/admin'], function () {
        Route::get('', 'Admin\Stats\AdminStatsIndexController@actionGetStatsView');

        Route::group(['prefix' => '/stats'], function () {
            Route::get('/payments', 'Admin\Stats\AdminStatsPaymentsController@actionGetStatsView');
            Route::get('/delivery', 'Admin\Stats\AdminStatsDeliveryController@actionGetStatsView');
            Route::get('/profit', 'Admin\Stats\AdminStatsProfitController@actionGetStatsView');
        });
    });

    Route::get('admin/search', 'Admin\Panel\AdminPanelController@searchUser')->name('adminTable.users.searchUser');

    Route::group(['prefix' => '/admin/stats/info'], function () {
        Route::put('/orders', 'Admin\Stats\AdminStatsIndexController@actionGetDataForStatsChart');
        Route::put('/payments', 'Admin\Stats\AdminStatsPaymentsController@actionGetDataForStatsChart');
        Route::put('/delivery', 'Admin\Stats\AdminStatsDeliveryController@actionGetDataForStatsChart');
        Route::put('/profit', 'Admin\Stats\AdminStatsProfitController@actionGetDataForStatsChart');
    });

    /**Start ADMIN PANEL Product AREA */
    Route::group(['prefix' => 'admin/products'], function () {
        Route::get('', 'Admin\Panel\AdminPanelProductController@getProducts')->name('AdminPanel.product.index');
        Route::get('{product}/edit', 'Admin\Panel\AdminPanelProductController@editProducts');
        Route::put('{product}/update', 'Admin\Panel\AdminPanelProductController@updateProducts');
//    Route::post('create', 'Admin\Panel\AdminPanelProductController@createProducts')->name('AdminPanel.product.create');
        Route::delete('{product}/delete', 'Admin\Products\AdminProductsDeleteController@actionDeleteProduct')
            ->name('AdminPanel.product.delete');

        Route::get('{product}/subproducts/{subproduct}/edit',
            'Admin\Panel\AdminPanelSubProductController@editSubProducts')->name('AdminPanel.subproduct.edit');
        Route::get('{product}/subproducts/list',
            'Admin\Panel\AdminPanelSubProductController@getSubProductsList')->name('AdminPanel.subproduct.list');

        Route::put('{product}/subproducts/{subproduct}/update',
            'Admin\Panel\AdminPanelSubProductController@updateSubProducts')->name('AdminPanel.subproduct.update');
        Route::put('{product}/subproducts/{subproduct}/dissociate',
            'Admin\Panel\AdminPanelSubProductController@dissociateSubProducts')->name('AdminPanel.subproduct.dissociate');
    });

    /**End ADMIN PANEL Product AREA */

    /**Start ADMIN PANEL SubProduct AREA */

    Route::group(['prefix' => 'admin/subproducts'], function () {
        Route::get('create',
            'Admin\Panel\AdminPanelSubProductController@createSubProduct')->name('AdminPanel.subproduct.create');
        Route::post('store',
            'Admin\Panel\AdminPanelSubProductController@storeSubProduct')->name('AdminPanel.subproduct.store');
    });

    /**End ADMIN PANEL SubProduct AREA */


    Route::group(['prefix' => 'admin/discounts'], function () {
        Route::get('', 'Admin\Panel\AdminPanelDiscountController@getDiscounts')->name('AdminPanel.discounts.index');
        Route::get('create',
            'Admin\Panel\AdminPanelDiscountController@createDiscount')->name('AdminPanel.discounts.create');
        Route::post('', 'Admin\Panel\AdminPanelDiscountController@storeDiscount')->name('AdminPanel.discounts.store');
        Route::get('{discount}/edit',
            'Admin\Panel\AdminPanelDiscountController@editDiscount')->name('AdminPanel.discounts.edit');
        Route::put('{discount}',
            'Admin\Panel\AdminPanelDiscountController@updateDiscount')->name('AdminPanel.discounts.update');
        Route::delete('{discount}',
            'Admin\Panel\AdminPanelDiscountController@deleteDiscount')->name('AdminPanel.discounts.delete');
        Route::get('{discount}',
            'Admin\Panel\AdminPanelDiscountController@showDiscount')->name('AdminPanel.discounts.show');

        Route::post('{discount}/usercategories',
            'Admin\Panel\AdminPanelDiscountUserController@addUserCategories')->name('AdminPanel.discounts.addUserCategories');
        Route::get('{discount}/usercategories',
            'Admin\Panel\AdminPanelDiscountUserController@showAddingUserCategories')->name('AdminPanel.discounts.showAddingUserCategories');


    });
    Route::group(['prefix' => 'admin/users'], function () {
        Route::get('{user}', 'Admin\Panel\AdminPanelController@getUser')->name('adminTable.users.index');
        Route::post('', 'Admin\Panel\AdminPanelController@showUsers')->name('adminTable.user.showUsers');
        Route::put('update', 'Admin\Panel\AdminPanelController@updateUser')->name('adminTable.user.update');
        Route::put('{user}/updateCategories', 'Admin\Panel\AdminPanelController@updateUsersCategories')
            ->name('adminTable.user.updateCategories');

        Route::put('{user}/updateBonuses', 'Admin\Panel\AdminPanelController@updateUsersBonuses')
            ->name('adminTable.user.updateUsersBonuses');
        Route::put('{user}/updateBalance', 'Admin\Panel\AdminPanelController@updateUsersBalance')
            ->name('adminTable.user.updateUsersBalance');

        Route::delete('delete', 'Admin\Panel\AdminPanelController@destroyUser')->name('adminTable.user.delete');
        Route::get('{user}/orders/{order}',
            'Admin\Panel\AdminPanelOrderController@getUsersOrder')->name('adminPanel.order.index');
        Route::get('{user}/orders/{order}/subproducts/{subproduct}',
            'Admin\Panel\AdminPanelSubProductController@getSubProduct')
            ->name('adminPanel.subProduct.index');

        Route::put('{user}/addDiscounts', 'Admin\Panel\AdminPanelDiscountUserController@addDiscounts')
            ->name('AdminPanel.user.addDiscounts');
        Route::put('{user}/removeDiscounts/{discount}', 'Admin\Panel\AdminPanelDiscountUserController@removeDiscounts')
            ->name('AdminPanel.user.removeDiscounts');

        //Role SECTION
        Route::get('{user}/manage_role', 'Admin\Panel\AdminPanelUserRoleController@getAssignRoleView');
        Route::post('{user}/manage_role', 'Admin\Panel\AdminPanelUserRoleController@assignRole');

        /**Start ADMIN PANEL ORDER AREA */
        Route::group(['prefix' => '{user}/orders/{order}'], function () {
            Route::put('status/update', 'Admin\Panel\AdminPanelOrderController@updateOrderStatus')
                ->name('adminPanel.orderStatus.update');
            Route::put('update', 'Admin\Panel\AdminPanelOrderController@updateOrderIndex')
                ->name('adminPanel.orderIndex.update');
            Route::put('delivery/update', 'Admin\Panel\AdminPanelOrderController@updateOrderDelivery')
                ->name('adminPanel.orderDelivery.update');
            Route::put('contactDetails/update', 'Admin\Panel\AdminPanelOrderController@updateOrderContactDetails')
                ->name('adminPanel.orderContactDetails.update');
            Route::put('orderPayment/update', 'Admin\Panel\AdminPanelOrderController@updateOrderPayment')
                ->name('adminPanel.orderPayment.update');
            Route::put('orderDiscount/update', 'Admin\Panel\AdminPanelOrderController@updateOrderDiscount')
                ->name('adminPanel.orderDiscount.update');
            Route::put('orderBonuses/update', 'Admin\Panel\AdminPanelOrderController@updateOrderBonuses')
                ->name('adminPanel.orderBonuses.update');

            Route::put('orderBalance/update', 'Admin\Panel\AdminPanelOrderController@updateOrderBalance')
                ->name('adminPanel.orderBalance.update');
        });

        /**END ADMIN PANEL ORDER AREA */
    });


    /** END ADMIN PANEL AREA */


    /*
     *  Route to receive messages from the payment systems
     * @incoming get[pay_system] - name payment system
     */
    Route::match(['get', 'post'], '/payments_check/{pay_system}',
        ['uses' => 'Payments\Receive\PaymentsReceiveController@actionIndex']);
    /*
     *  end report payments ares
     */
    Route::get('test_form_liqpay', 'Payments\Receive\TestFormPaymentsReceiveLiqpay@actionIndex');

    /** ADMIN AREA */

    Route::group(['prefix' => 'admin/products'], function () {
        Route::get('/', ['uses' => 'Admin\Products\AdminProductsReadController@actionReadProduct']);

        Route::get('/create', ['uses' => 'Admin\Products\AdminProductsCreateController@actionGetCreateProductForm']);
        Route::post('/create', ['uses' => 'Admin\Products\AdminProductsCreateController@actionCreateProduct']);
//    Route::get('/sub_product/{id}', [ 'uses' => 'Admin\Products\AdminProductsCreateController@actionGetSubProductView' ]);

        Route::get('/update/{product_id}',
            ['uses' => 'Admin\Products\AdminProductsUpdateController@actionGetUpdateProductForm'])
            ->name('AdminPanel.product.edit');
        Route::put('/update/{product_id}',
            ['uses' => 'Admin\Products\AdminProductsUpdateController@actionUpdateProduct'])
            ->where(['product_id' => '[1-9]+'])->name('AdminPanel.product.update');

//    Route::delete('delete/{product_id}', [ 'uses' => 'Admin\Products\AdminProductsDeleteController@actionDeleteProduct' ])
//       ->name('AdminPanel.product.delete');
    });

    Route::group(['prefix' => '/admin'], function () {
        // DEPARTMENTS AREA
        Route::group(['prefix' => '/departments'], function () {
            Route::get('/content',
                ['uses' => 'Admin\Departments\Content\AdminDepartmentsContentController@actionGetView']);
            Route::put('/content/edit',
                ['uses' => 'Admin\Departments\Content\AdminDepartmentsContentEditController@actionGetEditView']);
            Route::post('/content/edit',
                ['uses' => 'Admin\Departments\Content\AdminDepartmentsContentEditController@actionEdit']);

            Route::get('/photography',
                ['uses' => 'Admin\Departments\Photography\AdminDepartmentPhotographyController@actionGetView']);
            Route::put('/photography/edit',
                ['uses' => 'Admin\Departments\Photography\AdminDepartmentPhotographyEditController@actionGetEditView']);
            Route::post('/photography/edit',
                ['uses' => 'Admin\Departments\Photography\AdminDepartmentPhotographyEditController@actionEdit']);

            Route::get('/approve',
                ['uses' => 'Admin\Departments\AdminDepartmentsApproveController@actionApproveProduct']);
        });
        // END DEPARTMENTS AREA
    });


    Route::group(['prefix' => 'admin/manage'], function () {
        Route::group(['prefix' => '/brands'], function () {
            Route::get('/', ['uses' => 'Admin\Manage\Brands\AdminManageBrandsReadController@actionRead']);

            Route::get('/create',
                ['uses' => 'Admin\Manage\Brands\AdminManageBrandsCreateController@actionGetCreateView']);
            Route::post('/create', ['uses' => 'Admin\Manage\Brands\AdminManageBrandsCreateController@actionCreate']);

            Route::get('/update/{brand_id}',
                ['uses' => 'Admin\Manage\Brands\AdminManageBrandsUpdateController@actionGetUpdateView'])
                ->where(['brand_id' => '[1-9]+']);
            Route::post('/update', ['uses' => 'Admin\Manage\Brands\AdminManageBrandsUpdateController@actionUpdate']);

            Route::delete('/delete', ['uses' => 'Admin\Manage\Brands\AdminManageBrandsDeleteController@actionDelete']);
        });

        Route::group(['prefix' => '/colors'], function () {
            Route::get('/', ['uses' => 'Admin\Manage\Colors\AdminManageColorsReadController@actionRead']);

            Route::get('/create',
                ['uses' => 'Admin\Manage\Colors\AdminManageColorsCreateController@actionGetCreateView']);
            Route::post('/create', ['uses' => 'Admin\Manage\Colors\AdminManageColorsCreateController@actionCreate']);

            Route::get('/update/{color_id}',
                ['uses' => 'Admin\Manage\Colors\AdminManageColorsUpdateController@actionGetUpdateView'])
                ->where(['color_id' => '[1-9]+']);
            Route::post('/update', ['uses' => 'Admin\Manage\Colors\AdminManageColorsUpdateController@actionUpdate']);

            Route::delete('/delete', ['uses' => 'Admin\Manage\Colors\AdminManageColorsDeleteController@actionDelete']);
        });

        Route::group(['prefix' => '/sizes'], function () {
            Route::get('/', ['uses' => 'Admin\Manage\Sizes\AdminManageSizesReadController@actionRead']);

            Route::get('/create',
                ['uses' => 'Admin\Manage\Sizes\AdminManageSizesCreateController@actionGetCreateView']);
            Route::post('/create', ['uses' => 'Admin\Manage\Sizes\AdminManageSizesCreateController@actionCreate']);

            Route::get('/update/{size_id}',
                ['uses' => 'Admin\Manage\Sizes\AdminManageSizesUpdateController@actionGetUpdateView'])
                ->where(['size_id' => '[1-9]+']);
            Route::post('/update', ['uses' => 'Admin\Manage\Sizes\AdminManageSizesUpdateController@actionUpdate']);

            Route::delete('/delete', ['uses' => 'Admin\Manage\Sizes\AdminManageSizesDeleteController@actionDelete']);
        });

        Route::group(['prefix' => 'categories'], function () {
            Route::get('', 'Admin\Manage\Categories\AdminManageCategoriesReadController@actionRead');

            Route::get('/create', 'Admin\Manage\Categories\AdminManageCategoriesCreateController@actionGetCreateView');
            Route::post('/create', 'Admin\Manage\Categories\AdminManageCategoriesCreateController@actionStore');

            Route::get('/update/{category_id}',
                ['uses' => 'Admin\Manage\Categories\AdminManageCategoriesUpdateController@actionGetUpdateView'])
                ->where(['category_id' => '[1-9]+']);
            Route::post('/update',
                ['uses' => 'Admin\Manage\Categories\AdminManageCategoriesUpdateController@actionUpdate']);

            Route::delete('/delete',
                ['uses' => 'Admin\Manage\Categories\AdminManageCategoriesDeleteController@actionDelete']);
        });

        Route::group(['prefix' => 'size_chart'], function () {
            Route::get('', 'Admin\Manage\SizeChart\AdminManageSizeChartReadController@actionRead');

            Route::get('create',
                ['uses' => 'Admin\Manage\SizeChart\AdminManageSizeChartCreateController@actionGetCreateView']);
            Route::post('create',
                ['uses' => 'Admin\Manage\SizeChart\AdminManageSizeChartCreateController@actionCreate']);

            Route::get('update/{size_id}',
                ['uses' => 'Admin\Manage\SizeChart\AdminManageSizeChartUpdateController@actionGetUpdateView'])
                ->where(['size_id' => '[1-9]+']);
            Route::post('update',
                ['uses' => 'Admin\Manage\SizeChart\AdminManageSizeChartUpdateController@actionUpdate']);

            Route::delete('delete',
                ['uses' => 'Admin\Manage\SizeChart\AdminManageSizeChartDeleteController@actionDelete']);
        });

        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', ['uses' => 'Admin\Manage\Roles\AdminManageRolesReadController@actionRead']);

            Route::get('/create',
                ['uses' => 'Admin\Manage\Roles\AdminManageRolesCreateController@actionGetCreateView']);
            Route::post('/create', ['uses' => 'Admin\Manage\Roles\AdminManageRolesCreateController@actionCreate']);

            Route::get('/update/{role_id}',
                ['uses' => 'Admin\Manage\Roles\AdminManageRolesUpdateController@actionGetUpdateView'])
                ->where(['role_id' => '[1-9]+']);
            Route::post('/update', ['uses' => 'Admin\Manage\Roles\AdminManageRolesUpdateController@actionUpdate']);

            Route::delete('/delete', ['uses' => 'Admin\Manage\Roles\AdminManageRolesDeleteController@actionDelete']);

            Route::get('{role_id}/users', 'Admin\Manage\Roles\AdminManageRolesUsersController@getUsers');
        });
    });

    /** IMPORT */

    Route::group(['prefix' => 'admin/import'], function () {
        Route::get('/', ['uses' => 'Admin\Import\AdminImportIndexController@actionIndex']);

        Route::group(['prefix' => '/parties'], function()
        {
            Route::put('/search/{buyer_id?}',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesReadController@actionGetViewForRead' ]
            );
            Route::put('/create',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesCreateController@actionGetViewForCreate' ]
            );
            Route::post('/create',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesCreateController@actionCreate' ]
            );
            Route::put('/edit',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesEditController@actionGetViewForEdit' ]
            );
            Route::post('/edit',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesEditController@actionEdit' ]
            );
            Route::put('/delete',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesDeleteController@actionGetViewForDelete' ]
            );
            Route::delete('/delete',
                [ 'uses' => 'Admin\Import\Parties\AdminImportPartiesDeleteController@actionDelete' ]
            );
        });

        Route::group(['prefix' => '/sales'], function()
        {
            Route::put('/search',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesReadController@actionGetViewForRead' ]
            );
            Route::put('/create',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesCreateController@actionGetViewForCreate' ]
            );
            Route::post('/create',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesCreateController@actionCreate' ]
            );
            Route::put('/edit',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesEditController@actionGetViewForEdit' ]
            );
            Route::post('/edit',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesEditController@actionEdit' ]
            );
            Route::put('/delete',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesDeleteController@actionGetViewForDelete' ]
            );
            Route::delete('/delete',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesDeleteController@actionDelete' ]
            );
            Route::put('/association',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesAssociationController@actionGetViewForAssociation' ]
            );
            Route::put('/association/confirm',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesAssociationController@actionConfirmParty' ]
            );
            Route::put('/association/cancel',
                [ 'uses' => 'Admin\Import\Sales\AdminImportSalesAssociationController@actionCancelParty' ]
            );
        });

        Route::group(['prefix' => '/uploading'], function()
        {
            Route::put('/create',
                ['uses' => 'Admin\Import\Uploading\AdminImportUploadingCreateController@actionGetViewForCreate']
            );
            Route::post('/create',
                ['uses' => 'Admin\Import\Uploading\AdminImportUploadingCreateController@actionCreate']
            );
            Route::post('/prepare',
                ['uses' => 'Admin\Import\Uploading\AdminImportUploadingPrepareController@actionParse']
            );
            Route::post('/prepare/errors',
                ['uses' => 'Admin\Import\Uploading\AdminImportUploadingPrepareErrorsController@actionGetErrorsFile']
            );
        });
    });
//});
