<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'company' => $faker->company,
        'phone_number' => $faker->e164PhoneNumber,
        'address' => $faker->streetAddress,
        'is_hidden' => $faker->boolean,
    ];
});
