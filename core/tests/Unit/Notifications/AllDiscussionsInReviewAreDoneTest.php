<?php

namespace Tests\Unit\Notifications;

use App\Domain\Contract\Notifications\Context\Review;
use App\Model\Telegram\User;
use App\Notifications\AllDiscussionsInReviewAreDone;
use App\Notifications\AbstractNotification;
use App\Notifications\Message\TelegramFactory;
use Illuminate\Foundation\Testing\WithFaker;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Tests\TestCase;

class AllDiscussionsInReviewAreDoneTest extends TestCase
{
	use WithFaker;

	/**
	 * @var TelegramFactory|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $telegramMessageFactory;

	/**
	 * @var User|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $notifiable;

	/**
	 * @var Review|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $context;

	/**
	 * @var AllDiscussionsInReviewAreDone
	 */
	private $notification;

	protected function setUp(): void
	{
		parent::setUp();

		$this->telegramMessageFactory = $this->createMock(TelegramFactory::class);
		$this->notifiable             = $this->createMock(User::class);
		$this->context                = $this->createMock(Review::class);
		$this->notification           = new AllDiscussionsInReviewAreDone($this->telegramMessageFactory);

		$this->notification->setContext($this->context);
	}

	public function testVia(): void
	{
		self::assertSame([TelegramChannel::class, AbstractNotification::BASE_CHANNEL_DATABASE], $this->notification->via());
	}

	public function testToTelegram()
	{
		$branch       = $this->faker->text;
		$author       = $this->faker->firstName();
		$reviewLink   = $this->faker->url;
		$taskLink     = $this->faker->url;
		$notifiableId = $this->faker->randomNumber();

		$this->context->expects(self::once())->method('getBranch')->willReturn($branch);
		$this->context->expects(self::once())->method('getAuthor')->willReturn($author);
		$this->context->expects(self::once())->method('getReviewLink')->willReturn($reviewLink);
		$this->context->expects(self::once())->method('getTaskLink')->willReturn($taskLink);

		$this->notifiable->expects(self::once())->method('getId')->willReturn($notifiableId);

		$telegramMessage = $this->createMock(TelegramMessage::class);
		$this->telegramMessageFactory->expects(self::once())
			->method('createAllDiscussionsInReviewAreDone')
			->with(
				$branch,
				$author,
				$reviewLink,
				$taskLink
			)->willReturn($telegramMessage);

		$telegramMessage->expects(self::once())->method('to')->with($notifiableId)->willReturn($telegramMessage);

		self::assertSame($telegramMessage, $this->notification->toTelegram($this->notifiable));
	}

	public function testToArray(): void
	{
		$reviewId = $this->faker->text;
		$this->context->expects(self::once())->method('getReviewId')->willReturn($reviewId);
		self::assertSame(
			[AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID => $reviewId],
			$this->notification->toArray($this->notifiable)
		);
	}

	public function testGetContext(): void
	{
		self::assertSame($this->context, $this->notification->getContext());
	}
}
