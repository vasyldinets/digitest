<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// Add customers
$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'cardNumber' => $faker->unique()->creditCardNumber,
        'cardMonth' => $faker->numberBetween(1,12),
        'cardYear' => $faker->numberBetween(2018,2028),
        'cardCvv' => $faker->numberBetween(100,999),
        'cardLimit' => 10000,
    ];
});

// Add transactions
$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'customerId' => $faker->numberBetween(1,2),
        'sellerId' => 1,
        'amount' => $faker->numberBetween(1,1500),
        'offset' => $faker->numberBetween(-1500,-1),
        'limit' => $faker->numberBetween(1,10000),
        'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});