<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Notifications;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(
	DatabaseNotification::class,
	function (Faker $faker) {
		$type = $faker->randomElement([
              Notifications\AllDiscussionsInReviewAreDone::class, Notifications\NewReview::class
        ]);

		$notifiableType = $faker->randomElement([Model\User::class, Model\Telegram\User::class]);

		return [
			'id'              => $faker->uuid,
			'type'            => $type,
			'notifiable_type' => $notifiableType,
			'notifiable_id'   => factory($notifiableType)->create()->id,
			'data'            => $faker->randomElements(),
		];
	}
);