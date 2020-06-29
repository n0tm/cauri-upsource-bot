<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Telegram\User::class, function (Faker $faker) {
    return [
        'id'             => $faker->randomDigit,
        'user_id'        => factory(Model\User::class)->create()->id,
        'review_chat_id' => $faker->randomDigit
    ];
});
