<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram\Context;

use App\Domain\Implementation\Action\Telegram\Context\UpdateReviewNotificationMessage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateReviewNotificationMessageTest extends TestCase
{
	use WithFaker;

	public function testGetChatId(): void
	{
		$chatId    = $this->faker->randomNumber();
		$messageId = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$context = new UpdateReviewNotificationMessage($chatId, $messageId, $reviewId);

		self::assertSame($chatId, $context->getChatId());
	}

	public function testGetMessageId(): void
	{
		$chatId    = $this->faker->randomNumber();
		$messageId = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$context = new UpdateReviewNotificationMessage($chatId, $messageId, $reviewId);

		self::assertSame($messageId, $context->getMessageId());
	}

	public function testGetReviewId(): void
	{
		$chatId    = $this->faker->randomNumber();
		$messageId = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$context = new UpdateReviewNotificationMessage($chatId, $messageId, $reviewId);

		self::assertSame($reviewId, $context->getReviewId());
	}
}
