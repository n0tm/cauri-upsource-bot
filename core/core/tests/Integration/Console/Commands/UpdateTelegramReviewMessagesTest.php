<?php

namespace Tests\Integration\Console\Commands;

use App\Domain\Implementation\Action\Telegram\UpdateReviewNotificationMessage;
use App\Model\Telegram\ReviewNotificationMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Contract;

class UpdateTelegramReviewMessagesTest extends TestCase
{
	use WithFaker;
	use RefreshDatabase;

	public function testHandle(): void
	{
		/** @var ReviewNotificationMessage $reviewNotificationMessages */
		$reviewNotificationMessage = factory(ReviewNotificationMessage::class, 1)->create()->first();
		$updateReviewNotificationMessageContext = $this->createMock(Contract\Action\Telegram\Context\UpdateReviewNotificationMessage::class);

		$contextFactory = $this->createMock(Contract\Action\Telegram\ContextFactory::class);
		$this->app->instance(Contract\Action\Telegram\ContextFactory::class, $contextFactory);
		$contextFactory->expects(self::once())
			->method('createUpdateReviewNotificationMessage')
			->with(
				$reviewNotificationMessage->getChatId(),
				$reviewNotificationMessage->getMessageId(),
				$reviewNotificationMessage->getReviewId()
			)->willReturn($updateReviewNotificationMessageContext);

		$action = $this->createMock(UpdateReviewNotificationMessage::class);
		$this->app->instance(UpdateReviewNotificationMessage::class, $action);
		$action->expects(self::once())
			->method('process')
			->with($updateReviewNotificationMessageContext);

		$this->artisan('telegram:update_review_messages')->assertExitCode(0);
	}
}
