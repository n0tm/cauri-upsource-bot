<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->unique()->safeEmail,
        'surname' => $faker->lastName,
    ];
});
