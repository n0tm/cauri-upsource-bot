<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram;

use App\Domain\Contract;
use App\Domain\Implementation\Action\Telegram\DeleteReviewersNotificationsAboutAllDoneDiscussions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteReviewersNotificationsAboutAllDoneDiscussionsTest extends TestCase
{
	use WithFaker;

	public function testProcess(): void
	{
		$context = $this->createMock(Contract\Action\Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions::class);
		$reviewId = $this->faker->text;
		$context->expects(self::once())->method('getReviewId')->willReturn($reviewId);

		$notificationsRepository = $this->createMock(Contract\Repository\Notifications::class);
		$notificationsRepository->expects(self::once())
			->method('deleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview')
			->with($reviewId);

		$action = new DeleteReviewersNotificationsAboutAllDoneDiscussions($notificationsRepository);
		$action->process($context);
	}
}
