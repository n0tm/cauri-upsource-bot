<?php

namespace Tests\Unit\Notifications;

use App\Domain\Contract;
use App\Model\Telegram\User;
use App\Notifications\Message\TelegramFactory;
use App\Notifications\NewReview;
use Illuminate\Foundation\Testing\WithFaker;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Tests\TestCase;

class NewReviewTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Notifications\Context\Review|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $context;

	/**
	 * @var NewReview
	 */
	private $notification;

	/**
	 * @var TelegramFactory|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $telegramMessageFactory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->context                = $this->createMock(Contract\Notifications\Context\Review::class);
		$this->telegramMessageFactory = $this->createMock(TelegramFactory::class);

		$this->notification = new NewReview($this->telegramMessageFactory);
	}

	public function testVia(): void
	{
		$this->assertSame([TelegramChannel::class], $this->notification->via());
	}

	public function testToTelegram(): void
	{
		$reviewLink = $this->faker->url;
		$author     = $this->faker->name;
		$branch     = $this->faker->text;
		$taskLink   = $this->faker->url;

		$this->context->expects(self::once())
			->method('getReviewLink')
			->willReturn($reviewLink);
		$this->context->expects(self::once())
			->method('getAuthor')
			->willReturn($author);
		$this->context->expects(self::once())
			->method('getBranch')
			->willReturn($branch);
		$this->context->expects(self::once())
			->method('getTaskLink')
			->willReturn($taskLink);

		$reviewChatId = $this->faker->randomNumber();
		$notifiableTelegramUser = $this->createMock(User::class);
		$notifiableTelegramUser->expects(self::once())->method('getReviewChatId')->willReturn($reviewChatId);

		$newReviewMessage = $this->createMock(TelegramMessage::class);
		$newReviewMessage->expects(self::once())->method('to')->with($reviewChatId)->willReturn($newReviewMessage);

		$this->telegramMessageFactory->expects(self::once())
			->method('createNewReview')
			->with(
				$reviewLink,
				$author,
				$branch,
				$taskLink
			)->willReturn($newReviewMessage);

		$this->notification->setContext($this->context);
		self::assertSame($newReviewMessage, $this->notification->toTelegram($notifiableTelegramUser));
	}

	public function testGetAndSetContext(): void
	{
		$this->notification->setContext($this->context);
		self::assertSame($this->context, $this->notification->getContext());
	}
}