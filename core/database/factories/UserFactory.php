<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

const TEST_USER_ID = 1;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->unique()->safeEmail,
        'surname' => $faker->lastName,
    ];
});
