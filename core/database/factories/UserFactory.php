<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;

const TEST_USER_ID = 1;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->unique()->safeEmail,
        'surname' => $faker->lastName,
    ];
});
