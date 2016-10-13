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
        'total_sum' => 25000,
        'original_sum' => 20000,
        'total_quantity' => 5,
        'payment_type_id' => \App\Models\Payment\PaymentTypesModel::first()->id,
    ];
});
