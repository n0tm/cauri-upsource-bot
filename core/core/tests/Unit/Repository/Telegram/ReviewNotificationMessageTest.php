<?php

namespace Tests\Unit\Repository\Telegram;

use App\Repository\Telegram\ReviewNotificationMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use App\Domain\Contract;
use Tests\TestCase;

class ReviewNotificationMessageSpy extends ReviewNotificationMessage {
	/**
	 * @var Model
	 */
	private $model;

	public function setModel(Model $model): void
	{
		$this->model = $model;
	}

	protected function getModel(): Model
	{
		return $this->model;
	}
}

class ReviewNotificationMessageTest extends TestCase
{
	use WithFaker;

	/**
	 * @var ReviewNotificationMessageSpy
	 */
	private $repository;

	/**
	 * @var \App\Model\Telegram\ReviewNotificationMessage|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $model;

	protected function setUp(): void
	{
		parent::setUp();

		$this->repository = new ReviewNotificationMessageSpy();
		$this->model = $this->createMock(\App\Model\Telegram\ReviewNotificationMessage::class);
		$this->repository->setModel($this->model);
	}

	public function testCreate()
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->text;

		$this->model->expects(self::exactly(3))
			->method('setAttribute')
			->withConsecutive(
				[\App\Model\Telegram\ReviewNotificationMessage::COLUMN_NAME_MESSAGE_ID, $messageId],
				[\App\Model\Telegram\ReviewNotificationMessage::COLUMN_NAME_CHAT_ID, $chatId],
				[\App\Model\Telegram\ReviewNotificationMessage::COLUMN_NAME_REVIEW_ID, $reviewId]
			);

		$this->model->expects(self::once())->method('save')->willReturn(true);

		$this->repository->create($messageId, $chatId, $reviewId);
	}

	public function testIsExistsByReviewId(): void
	{
		$id = $this->faker->text;
		$isExists = $this->faker->boolean;

		$builder = $this->getMockBuilder(Builder::class)
			->disableOriginalConstructor()
			->onlyMethods(['where'])
			->addMethods(['exists'])
			->getMock();
		$builder->expects(self::once())
			->method('where')
			->with(['review_id' => $id])
			->willReturn($builder);
		$builder->expects(self::once())->method('exists')->willReturn($isExists);

		$this->model->expects(self::once())->method('newQuery')->willReturn($builder);

		self::assertSame($isExists, $this->repository->isExistsByReviewId($id));
	}

	public function testGetByReviewIdWhenRecordExists(): void
	{
		$id = $this->faker->text;

		$builder = $this->getMockBuilder(Builder::class)
			->disableOriginalConstructor()
			->onlyMethods(['where', 'first'])
			->getMock();
		$builder->expects(self::once())
			->method('where')
			->with(['review_id' => $id])
			->willReturn($builder);

		$entity = $this->createMock(Contract\Entity\Telegram\ReviewNotificationMessage::class);
		$record = $this->createMock(Contract\Record\Telegram\ReviewNotificationMessage::class);
		$record->expects(self::once())->method('getEntity')->willReturn($entity);

		$builder->expects(self::once())->method('first')->willReturn($record);

		$this->model->expects(self::once())->method('newQuery')->willReturn($builder);

		self::assertSame($entity, $this->repository->getByReviewId($id));
	}

	public function testGetByReviewIdWhenRecordNotExists(): void
	{
		$id = $this->faker->text;

		$builder = $this->getMockBuilder(Builder::class)
			->disableOriginalConstructor()
			->onlyMethods(['where', 'first'])
			->getMock();
		$builder->expects(self::once())
			->method('where')
			->with(['review_id' => $id])
			->willReturn($builder);

		$builder->expects(self::once())->method('first');

		$this->model->expects(self::once())->method('newQuery')->willReturn($builder);

		self::assertNull($this->repository->getByReviewId($id));
	}
}
