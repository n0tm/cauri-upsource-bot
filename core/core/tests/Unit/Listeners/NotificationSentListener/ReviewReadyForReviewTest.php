<?php

namespace Tests\Unit\Listeners\NotificationSentListener;

use App\Domain\Contract\Repository\Telegram\ReviewNotificationMessage;
use App\Listeners\NotificationSentListener;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewReadyForReviewTest extends TestCase
{
	use WithFaker;

	public function testHandle(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId = $this->faker->randomNumber();
		$reviewId = $this->faker->text;

		$context = $this->createMock(NotificationSentListener\Context\ReviewReadyForReview::class);
		$context->expects($this->once())->method('getMessageId')->willReturn($messageId);
		$context->expects($this->once())->method('getChatId')->willReturn($chatId);
		$context->expects($this->once())->method('getReviewId')->willReturn($reviewId);

		$repository = $this->createMock(ReviewNotificationMessage::class);
		$repository->expects($this->once())->method('create')->with($messageId, $chatId, $reviewId);

		$listener = new NotificationSentListener\ReviewReadyForReview($repository);
		$listener->handle($context);
	}
}
