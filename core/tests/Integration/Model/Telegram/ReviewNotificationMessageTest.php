<?php

namespace Tests\Integration\Model\Telegram;

use App\Model;
use Tests\TestCase;

class ReviewNotificationMessageTest extends TestCase
{
	/**
	 * relations tests
	 */
	public function testReview(): void
	{
		/** @var Model\Upsource\Review  $review */
		$review = factory(Model\Upsource\Review::class)->create();

		/** @var Model\Telegram\ReviewNotificationMessage $reviewNotificationMessage */
		$reviewNotificationMessage = factory(Model\Telegram\ReviewNotificationMessage::class)->create([
            'review_id' => $review->id,
        ]);

		self::assertSame($reviewNotificationMessage->review_id, $reviewNotificationMessage->getReview()->getId());
	}
}
