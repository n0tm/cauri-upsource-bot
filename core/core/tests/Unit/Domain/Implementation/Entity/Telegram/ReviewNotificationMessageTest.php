<?php

namespace Tests\Unit\Domain\Implementation\Entity\Telegram;

use App\Domain\Contract;
use App\Domain\Implementation;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewNotificationMessageTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Implementation\Entity\Telegram\ReviewNotificationMessage
	 */
	private $entity;

	/**
	 * @var Contract\Record\Telegram\ReviewNotificationMessage|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $record;

	protected function setUp(): void
	{
		parent::setUp();

		$this->record = $this->createMock(Contract\Record\Telegram\ReviewNotificationMessage::class);
		$this->entity = new Implementation\Entity\Telegram\ReviewNotificationMessage($this->record);
	}

	public function testGetReviewId(): void
	{
		$reviewId = $this->faker->text;
		$this->record->expects(self::once())->method('getReviewId')->willReturn($reviewId);
		self::assertSame($reviewId, $this->entity->getReviewId());
	}

	public function testGetMessageId(): void
	{
		$messageId = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getMessageId')->willReturn($messageId);
		self::assertSame($messageId, $this->entity->getMessageId());
	}

	public function testGetChatId(): void
	{
		$chatId = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getChatId')->willReturn($chatId);
		self::assertSame($chatId, $this->entity->getChatId());
	}

	public function testGetRecord(): void
	{
		self::assertSame($this->record, $this->entity->getRecord());
	}
}
