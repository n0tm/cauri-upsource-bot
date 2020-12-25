<?php

namespace Tests\Unit\Listeners;

use App\Listeners;
use App\Notifications\Context\Review;
use App\Notifications\NewReview;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Events\NotificationSent;
use stdClass;
use Tests\TestCase;

class NotificationSentTest extends TestCase
{
	use WithFaker;

	public function testHandle()
	{
		$messageId    = $this->faker->randomNumber();
		$reviewChatId = $this->faker->randomNumber();
		$reviewId     = $this->faker->text;

		$readyForReviewContext = $this->createMock(Listeners\NotificationSentListener\Context\ReviewReadyForReview::class);
		$contextFactory = $this->createMock(Listeners\NotificationSentListener\Context\Factory::class);
		$contextFactory->expects($this->once())
			->method('createReviewReadyForReview')
			->with($messageId, $reviewChatId, $reviewId)
			->willReturn($readyForReviewContext);

		$readyForReviewListener = $this->createMock(Listeners\NotificationSentListener\ReviewReadyForReview::class);
		$readyForReviewListener->expects($this->once())->method('handle')->with($readyForReviewContext);
		$this->app->instance(Listeners\NotificationSentListener\ReviewReadyForReview::class, $readyForReviewListener);

		$notificationSentListener = new Listeners\NotificationSent($contextFactory);

		$event = $this->createMock(NotificationSent::class);

		$event->response['result']['message_id'] = $messageId;

		$event->notifiable = $this->getMockBuilder(stdClass::class)->addMethods(['getReviewChatId'])->getMock();
		$event->notifiable->expects(self::once())->method('getReviewChatId')->willReturn($reviewChatId);

		$newReviewContext = $this->createMock(Review::class);
		$newReviewContext->expects(self::once())->method('getReviewId')->willReturn($reviewId);

		$event->notification = $this->createMock(NewReview::class);
		$event->notification->expects(self::once())->method('getContext')->willReturn($newReviewContext);

		$notificationSentListener->handle($event);
	}
}
