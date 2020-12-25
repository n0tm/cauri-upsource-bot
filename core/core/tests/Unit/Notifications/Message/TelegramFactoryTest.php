<?php

namespace Tests\Unit\Notifications\Message;

use App\Domain\Contract;
use App\Notifications\Message;
use Illuminate\Foundation\Testing\WithFaker;
use NotificationChannels\Telegram\TelegramMessage;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class TelegramFactorySpy extends Message\TelegramFactory {

	/**
	 * @var TelegramMessage|MockObject
	 */
	private $basicMessage;

	public function setBasicMessage(TelegramMessage $message): void
	{
		$this->basicMessage = $message;
	}

	protected function getBasic()
	{
		return $this->basicMessage;
	}
}

class TelegramFactoryTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Message\Component\Factory|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $componentFactory;

	/**
	 * @var Message\TelegramFactory
	 */
	private $telegramFactory;

	/**
	 * @var TelegramMessage|MockObject
	 */
	private $telegramMessage;

	protected function setUp(): void
	{
		parent::setUp();

		$this->componentFactory = $this->createMock(Message\Component\Factory::class);
		$this->telegramFactory  = new TelegramFactorySpy($this->componentFactory);

		$this->telegramMessage  = $this->createMock(TelegramMessage::class);
		$this->telegramFactory->setBasicMessage($this->telegramMessage);
	}

	public function testCreateNewReviewWhenTaskLinkProvided()
	{
		$reviewLink = $this->faker->url;
		$author = $this->faker->text;
		$branch = $this->faker->text;
		$taskLink = $this->faker->url;

		$reviewMessageComponent = $this->createMock(Message\Component\NewReview::class);
		$reviewMessageComponent->expects(self::once())->method('setTitle')
			->with('Пользователь создал ревью')
			->willReturn($reviewMessageComponent);
		$reviewMessageComponent->expects(self::once())
			->method('setAuthor')
			->with($author)
			->willReturn($reviewMessageComponent);;
		$reviewMessageComponent->expects(self::once())
			->method('setBranch')
			->with($branch)
			->willReturn($reviewMessageComponent);

		$resultStringReviewMessageComponent = $this->faker->text;
		$reviewMessageComponent->expects(self::once())
			->method('toString')
			->willReturn($resultStringReviewMessageComponent);

		$this->componentFactory->expects(self::once())->method('createReview')->willReturn($reviewMessageComponent);
		$this->telegramMessage->expects(self::once())->method('options')
			->with(['parse_mode' => 'HTML'])
			->willReturn($this->telegramMessage);
		$this->telegramMessage->expects(self::exactly(2))
			->method('button')
			->withConsecutive(
				['Ревью', $reviewLink],
				['Задача', $taskLink]
			)->willReturn($this->telegramMessage);
		$this->telegramMessage->expects(self::once())
			->method('content')
			->with($resultStringReviewMessageComponent)
			->willReturn($this->telegramMessage);

		self::assertSame(
			$this->telegramMessage,
			$this->telegramFactory->createNewReview($reviewLink, $author, $branch, $taskLink)
		);
	}

	public function testCreateNewReviewWhenTaskLinkNotProvided()
	{
		$reviewLink = $this->faker->url;
		$author = $this->faker->text;
		$branch = $this->faker->text;

		$reviewMessageComponent = $this->createMock(Message\Component\NewReview::class);
		$reviewMessageComponent->expects(self::once())->method('setTitle')
			->with('Пользователь создал ревью')
			->willReturn($reviewMessageComponent);
		$reviewMessageComponent->expects(self::once())
			->method('setAuthor')
			->with($author)
			->willReturn($reviewMessageComponent);;
		$reviewMessageComponent->expects(self::once())
			->method('setBranch')
			->with($branch)
			->willReturn($reviewMessageComponent);

		$resultStringReviewMessageComponent = $this->faker->text;
		$reviewMessageComponent->expects(self::once())
			->method('toString')
			->willReturn($resultStringReviewMessageComponent);

		$this->componentFactory->expects(self::once())->method('createReview')->willReturn($reviewMessageComponent);
		$this->telegramMessage->expects(self::once())->method('options')
			->with(['parse_mode' => 'HTML'])
			->willReturn($this->telegramMessage);
		$this->telegramMessage->expects(self::once())
			->method('button')
			->with('Ревью', $reviewLink)
			->willReturn($this->telegramMessage);
		$this->telegramMessage->expects(self::once())
			->method('content')
			->with($resultStringReviewMessageComponent."\n\nНе удалось найти задачу привязанную к ветке")
			->willReturn($this->telegramMessage);

		self::assertSame(
			$this->telegramMessage,
			$this->telegramFactory->createNewReview($reviewLink, $author, $branch)
		);
	}
}
