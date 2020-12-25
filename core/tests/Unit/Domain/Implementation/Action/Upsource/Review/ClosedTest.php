<?php

namespace Tests\Unit\Domain\Implementation\Action\Upsource\Review;

use App\Domain\Implementation\Action\Upsource\Review\Closed;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Contract;

class ClosedTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Repository\Telegram\ReviewNotificationMessage|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $reviewNotificationMessageRepository;

	/**
	 * @var Contract\Api\Telegram\Facade|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $apiTelegram;

	/**
	 * @var Contract\Action\Upsource\Review\Context\Basic|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $context;

	/**
	 * @var Closed
	 */
	private $action;

	protected function setUp(): void
	{
		parent::setUp();

		$this->reviewNotificationMessageRepository = $this->createMock(Contract\Repository\Telegram\ReviewNotificationMessage::class);
		$this->apiTelegram = $this->createMock(Contract\Api\Telegram\Facade::class);
		$this->context = $this->createMock(Contract\Action\Upsource\Review\Context\Basic::class);

		$this->action = new Closed($this->reviewNotificationMessageRepository, $this->apiTelegram);
	}

	public function testProcessWhenNotificationMessageExists(): void
	{
		$reviewId = $this->faker->text;

		$this->context->expects(self::once())->method('getReviewId')->willReturn($reviewId);

		$reviewNotificationMessageChatId    = $this->faker->randomNumber();
		$reviewNotificationMessageMessageId = $this->faker->randomNumber();

		$reviewNotificationMessageEntity = $this->createMock(Contract\Entity\Telegram\ReviewNotificationMessage::class);
		$reviewNotificationMessageEntity->expects(self::once())
			->method('getChatId')
			->willReturn($reviewNotificationMessageChatId);
		$reviewNotificationMessageEntity->expects(self::once())
			->method('getMessageId')
			->willReturn($reviewNotificationMessageMessageId);

		$review = $this->createMock(Contract\Record\Upsource\Review::class);
		$review->expects(self::once())->method('delete');

		$reviewNotificationMessageRecord = $this->createMock(Contract\Record\Telegram\ReviewNotificationMessage::class);
		$reviewNotificationMessageRecord->expects(self::once())->method('getReview')->willReturn($review);
		$reviewNotificationMessageRecord->expects(self::once())->method('delete');

		$reviewNotificationMessageEntity->expects(self::once())
			->method('getRecord')
			->willReturn($reviewNotificationMessageRecord);


		$this->reviewNotificationMessageRepository->expects(self::once())
			->method('getByReviewId')
			->with($reviewId)
			->willReturn($reviewNotificationMessageEntity);

		$this->apiTelegram->expects(self::once())
			->method('deleteMessage')
			->with($reviewNotificationMessageChatId, $reviewNotificationMessageMessageId);

		$this->action->process($this->context);
	}

	public function testProcessWhenNotificationMessageNotExists(): void
	{
		$reviewId = $this->faker->text;

		$this->context->expects(self::once())->method('getReviewId')->willReturn($reviewId);

		$this->reviewNotificationMessageRepository->expects(self::once())
			->method('getByReviewId')
			->with($reviewId);

		$this->apiTelegram->expects(self::never())
			->method('deleteMessage');

		$this->action->process($this->context);
	}
}
