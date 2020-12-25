<?php

namespace Tests\Unit\Model\Telegram;

use App\Model\Telegram\ReviewNotificationMessage;
use \App\Domain\Implementation;
use \App\Domain\Contract;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewNotificationMessageTest extends TestCase
{
	use WithFaker;

	/**
	 * @var ReviewNotificationMessage
	 */
	private $record;

	public function setUp(): void
	{
		parent::setUp();

		$this->record = new ReviewNotificationMessage();
	}

	public function getEntity()
	{
		self::assertEquals(
			new Implementation\Entity\Telegram\ReviewNotificationMessage($this->record),
			$this->record->getEntity()
		);
	}

	public function testGetReviewId()
	{
		$reviewId = $this->faker->text;
		$this->record->review_id = $reviewId;
		self::assertSame($reviewId, $this->record->getReviewId());
	}

	public function testGetMessageId()
	{
		$messageId = $this->faker->randomNumber();
		$this->record->message_id = $messageId;
		self::assertSame($messageId, $this->record->getMessageId());
	}

	public function testGetChatId()
	{
		$chatId = $this->faker->randomNumber();
		$this->record->chat_id = $chatId;
		self::assertSame($chatId, $this->record->getChatId());
	}

	public function testGetReview()
	{
		$review = $this->createMock(Contract\Record\Upsource\Review::class);
		$this->record->review = $review;
		self::assertSame($review, $this->record->getReview());
	}
}
