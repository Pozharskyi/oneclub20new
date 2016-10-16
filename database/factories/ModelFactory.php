<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'date_of_birth' => $faker->dateTimeThisYear,
        'gender' => $faker->randomElement(['Male', 'Female']),
        'phone' => $faker->phoneNumber,
        'l_name' => $faker->lastName,
        'f_name' => $faker->firstName,
    ];
});

$factory->define(\App\Models\Order\OrderModel::class, function (Faker\Generator $faker) {

    return [
        'public_order_id' => '5555-9114-2332-0000',
        'comment' => $faker->word,
        'total_sum' => 20000,
        'original_sum' => 20000,
        'total_quantity' => 5,
//        'payment_type_id' => \App\Models\Payment\PaymentTypesModel::first()->id,
    ];
});

$factory->define(\App\Models\Payment\PaymentTypesModel::class, function (Faker\Generator $faker) {

    return [
        'payment_type' => 'Наличными',
    ];
});


$factory->define(\App\Models\Delivery\DeliveryTypesModel::class, function (Faker\Generator $faker) {

    return [
        'delivery_type' => 'Самовызов',
    ];
});


$factory->define(\App\Models\Discount\DiscountsModel::class, function (Faker\Generator $faker) {

    return [
        'discount_id' => '124adm124amkdwLda',
        'discount_amount' => '35',
        'active_from' => '2016-08-01 01:01:01',
        'active_to' => '2017-12-01 01:01:01',
        'status' => 'Активный',
        'comment' => 'test comment 1',
        'rule' => 'rule name 1',
        'auto' => '0',
        'type' => 'money',
        'min_basket_sum' => 500,
        'max_basket_sum' => 0,
        'purchase_number' => 0,
        'subproduct_amount_from' => null,
    ];
});

$factory->define(\App\Models\Discount\CouponRuleModel::class, function (Faker\Generator $faker) {

    return [
        'max_used_all' => 5,
        'max_used_user' => 3,
    ];
});

//attach order_id delivery_type_id
$factory->define(\App\Models\Order\OrderDeliveryModel::class, function (Faker\Generator $faker) {

    return [
        'delivery_f_name' => 'Елена',
        'delivery_l_name' => 'Гонтарева',
        'delivery_phone' => '950950951',
        'delivery_address' => 'ул. Маршала Тимошенка 5/7 кв. 91',
    ];
});

$factory->define(\App\Models\Order\OrderContactDetailsModel::class, function (Faker\Generator $faker) {

    return [
        'f_name' => 'Александр',
        'l_name' => 'Сердюк',
        'city' => 'Киев',
        'cell' => '950948268',
        'email' => 'serdiuk@smartdevelopers.eu',
    ];
});

// attach user_id
$factory->define(\App\Models\User\UserBalanceModel::class, function (Faker\Generator $faker) {

    return [
        'balance_amount' => 5000,
        'balance_comment' => 'new comment',
    ];
});

// attach user_id
$factory->define(\App\Models\User\UsersBonusesModel::class, function (Faker\Generator $faker) {

    return [
        'bonuses_amount' => 900,
        'bonuses_comment' => '1',
    ];
});

$factory->define(\App\Models\User\RoleModel::class, function (Faker\Generator $faker) {

    return [
        'name' => 'СуперАдмин',
        'description' => 'Все права доступа',
    ];
});

$factory->define(\App\Models\Product\ProductBrandsModel::class, function (Faker\Generator $faker) {

    return [
        'brand_name' => 'Blugirl',
        'made_by' => 1,
    ];
});

$factory->define(\App\Models\Product\ProductStockModel::class, function (Faker\Generator $faker) {

    return [
        'stock' => 'Интернет магазин',
    ];
});

$factory->define(\App\Models\Category\CategoryModel::class, function (Faker\Generator $faker) {

    return [
        'category_name' => 'Верхняя одежда',
        'parent_id' => 1,
        'made_by' => 1,
        'shortcut' => null,
    ];
});
$factory->define(\App\Models\Basic\BasicGenderModel::class, function (Faker\Generator $faker) {

    return [
        'name' => 'Женщины',
    ];
});

$factory->define(\App\Models\Product\ProductModel::class, function (Faker\Generator $faker) {

    return [
        'sku' => 'FW16HM732799',
        'product_store_id' => '1111-2222-3333-4449',
        'product_backend_id' => '7777-7777-7777-7779',
    ];
});

//assiciate sub_product_id
$factory->define(\App\Models\Product\ProductPopularityModel::class, function (Faker\Generator $faker) {
    return [
        'popularity' => 81,
    ];
});

$factory->define(\App\Models\Product\SubProductModel::class, function (Faker\Generator $faker) {
    return [
        'barcode' => '1234-5678-8765-9999',
        'dev_product_index_id' => 1,
        'dev_import_parties_id' => 1,
        'supplier_id' => 1,
        'markup_price' => '0',
        'quantity' => 20,
//        'dev_product_color_id' => 1,
//        'dev_product_size_id' => 1,
        'is_approved' => '1',
        'delivery_days' => 1,
    ];
});


$factory->define(\App\Models\Product\ProductColorModel::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Green',
        'made_by' => 1,         //TODO associate $user
    ];
});

$factory->define(\App\Models\Product\ProductSizeModel::class, function (Faker\Generator $faker) {
    return [
        'name' => 'M',
        'made_by' => 1,         //TODO associate $user
    ];
});

//associate subProduct_id
$factory->define(\App\Models\Product\ProductPhotoModel::class, function (Faker\Generator $faker) {
    return [
        'photo' => 'http://oneclub.ua/media/catalog/product/cache/1/small_image/1140x1710/9df78eab33525d08d6e5fb8d27136e95/d/s/dsc_0976_4.jpg',
    ];
});

//associate product_id
$factory->define(\App\Models\Product\ProductDescriptionModel::class, function (Faker\Generator $faker) {
    return [
        'product_name' => 'XXX Taylor',
        'supplier_product_name' => 'ZZZ Taylor',
        'product_description' => 'Test product 1',
        'product_composition' => 'Test composition 1',
        'comment_admin' => 'Тест тест тест',
        'comment_frontend' => 'Скидка не предоставляется',
        'country_manufacturer' => 'Испания',
        'product_delivery_days' => 2,
    ];
});

//associate sub_product_id
$factory->define(\App\Models\Product\ProductIndexPricesModel::class, function (Faker\Generator $faker) {
    return [
        'index_price' => 10000,
        'retail_price' => 9000,
        'final_price' => 15000,
        'special_price' => 5000,
        'sale_percent' => 33,
        'product_marga' => 5000,
    ];
});

$factory->define(\App\Models\Order\OrderIndexSubProductModel::class, function (Faker\Generator $faker) {
    return [
//        'dev_sub_product_id' => 1,
//        'dev_order_index_id' => 1,
        'dev_order_status_list_id' => 1,
        'price_for_one_product' => 1000,
        'qty' =>  1,
    ];
});

$factory->define(\App\Models\Discount\DiscountsModel::class, function (Faker\Generator $faker) {
    return [
        'discount_id' => '124adm124amkdwLda',
        'discount_amount' => '25',
        'active_from' => '2016-08-01 01:01:01',
        'active_to' => '2016-12-01 01:01:01',
        'status' => 'Активный',
        'comment' => 'test comment 1',
        'rule' => 'rule name 1',
        'auto' => '0',
        'type' => 'money',
        'min_basket_sum' => 500,
        'max_basket_sum' => 0,
        'purchase_number' => 0,
//        'coupon_rules_id' => 1,
        'subproduct_amount_from' => null,
    ];
});

$factory->define(\App\Models\Discount\CouponRuleModel::class, function (Faker\Generator $faker) {
    return [
        'max_used_all' => 5,
        'max_used_user' => 3,
    ];
});

$factory->define(\App\Models\User\UserBalanceModel::class, function (Faker\Generator $faker) {
    return [
//        'user_id' => 1,
        'balance_amount' => 1000,
        'balance_comment' => 'new comment',
    ];
});
$factory->define(\App\Models\Order\OrderBalanceModel::class, function (Faker\Generator $faker) {
    return [
//        'user_id' => 1,
        'balance_count' => 1000,
//        'dev_order_index_id' => 1,
    ];
});