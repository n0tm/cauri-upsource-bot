<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\TelegramUser;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(TelegramUser::class, function (Faker $faker) {
    return [
        'id' => $faker->randomDigit,
        'user_id' => factory(User::class)->create()->id,
        'review_chat_id' => $faker->randomDigit
    ];
});
