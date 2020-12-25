<?php

namespace Tests\Unit\Listeners\NotificationSentListener\Context;

use App\Listeners\NotificationSentListener\Context\ReviewReadyForReview;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewReadyForReviewTest extends TestCase
{
	use WithFaker;

	public function testGetMessageId(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$context = new ReviewReadyForReview($messageId, $chatId, $reviewId);
		self::assertSame($messageId, $context->getMessageId());
	}

	public function testGetChatId(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$context = new ReviewReadyForReview($messageId, $chatId, $reviewId);
		self::assertSame($chatId, $context->getChatId());
	}

	public function testGetReviewId(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$context = new ReviewReadyForReview($messageId, $chatId, $reviewId);
		self::assertSame($reviewId, $context->getReviewId());
	}
}
