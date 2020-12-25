<?php

namespace Tests\Unit\Listeners\NotificationSentListener\Context;

use App\Listeners\NotificationSentListener\Context;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryTest extends TestCase
{
	use WithFaker;

	public function testCreateReviewReadyForReview()
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$factory = new Context\Factory();
		$this->assertEquals(
			new Context\ReviewReadyForReview($messageId, $chatId, $reviewId),
			$factory->createReviewReadyForReview($messageId, $chatId, $reviewId)
		);
	}
}
