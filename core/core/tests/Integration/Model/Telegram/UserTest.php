<?php

namespace Tests\Integration\Model\Telegram;

use App\Model\Telegram\User;
use App\Domain\Contract;
use App\Notifications;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserTest extends TestCase
{
	public function testNotifyAboutNewReview(): void
	{
		Notification::fake();

		$context = $this->createMock(Contract\Notifications\Context\Review::class);

		/** @var User $user */
		$user = factory(User::class)->create();
		$user->notifyAboutNewReview($context);

		Notification::assertSentTo($user, Notifications\NewReview::class);
	}

	public function testNotifyAboutAllDoneDiscussions(): void
	{
		Notification::fake();

		$context = $this->createMock(Contract\Notifications\Context\Review::class);

		/** @var User $user */
		$user = factory(User::class)->create();
		$user->notifyAboutAllDoneDiscussions($context);

		Notification::assertSentTo($user, Notifications\AllDiscussionsInReviewAreDone::class);
	}
}
