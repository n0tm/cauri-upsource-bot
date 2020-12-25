<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram;

use App\Domain\Contract\Record\Upsource\Review;
use App\Domain\Implementation\Action\Telegram;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContextFactoryTest extends TestCase
{
	use WithFaker;

	public function testCreateUpdateReviewNotificationMessage(): void
	{
		$chatId    = $this->faker->randomNumber();
		$messageId = $this->faker->randomNumber();
		$reviewId  = $this->faker->text();

		$factory = new Telegram\ContextFactory();
		self::assertEquals(
			new Telegram\Context\UpdateReviewNotificationMessage($chatId, $messageId, $reviewId),
			$factory->createUpdateReviewNotificationMessage($chatId, $messageId, $reviewId)
		);
	}

	public function testCreateNotifyReviewersAboutAllDoneDiscussions(): void
	{
		$review = $this->createMock(Review::class);

		$factory = new Telegram\ContextFactory();
		self::assertEquals(
			new Telegram\Context\NotifyReviewersAboutAllDoneDiscussions($review),
			$factory->createNotifyReviewersAboutAllDoneDiscussions($review)
		);
	}

	public function testCreateDeleteReviewersNotificationsAboutAllDoneDiscussions(): void
	{
		$reviewId  = $this->faker->text();

		$factory = new Telegram\ContextFactory();
		self::assertEquals(
			new Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions($reviewId),
			$factory->createDeleteReviewersNotificationsAboutAllDoneDiscussions($reviewId)
		);
	}
}
