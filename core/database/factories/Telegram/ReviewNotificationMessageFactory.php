<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Telegram\ReviewNotificationMessage::class, function (Faker $faker) {
	return [
		'review_id'  => factory(Model\Upsource\Review::class)->create()->id,
		'message_id' => $faker->randomDigit,
		'chat_id'    => $faker->randomDigit
	];
});
