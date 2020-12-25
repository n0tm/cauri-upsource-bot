<?php

namespace Tests\Integration\Repository\Telegram;

use App\Model\Telegram\ReviewNotificationMessage as ReviewNotificationMessageModel;
use App\Repository\Telegram\ReviewNotificationMessage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewNotificationMessageTest extends TestCase
{
	use WithFaker;

	/**
	 * @var ReviewNotificationMessage
	 */
	private $repository;

	public function setUp(): void
	{
		parent::setUp();

		$this->repository = new ReviewNotificationMessage();
	}

	public function testCreate(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->randomNumber();

		$this->assertDatabaseMissing(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);

		$this->repository->create($messageId, $chatId, $reviewId);

		$this->assertDatabaseHas(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);
	}

	public function testIsExistsByReviewId(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->randomNumber();

		$this->assertDatabaseMissing(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);

		self::assertFalse($this->repository->isExistsByReviewId($reviewId));

		$model = new ReviewNotificationMessageModel();
		$model->message_id = $messageId;
		$model->chat_id    = $chatId;
		$model->review_id  = $reviewId;
		$model->save();

		$this->assertDatabaseHas(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);

		self::assertTrue($this->repository->isExistsByReviewId($reviewId));
	}

	public function testGetByReviewIdWhenRecordNotExists(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->randomNumber();

		$this->assertDatabaseMissing(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);

		self::assertNull($this->repository->getByReviewId($reviewId));
	}

	public function testGetByReviewIdWhenRecordExists(): void
	{
		$messageId = $this->faker->randomNumber();
		$chatId    = $this->faker->randomNumber();
		$reviewId  = $this->faker->randomNumber();

		$this->assertDatabaseMissing(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);

		$model = new ReviewNotificationMessageModel();
		$model->message_id = $messageId;
		$model->chat_id    = $chatId;
		$model->review_id  = $reviewId;
		$model->save();

		$this->assertDatabaseHas(
			'telegram_review_notifications_messages',
			[
				ReviewNotificationMessageModel::COLUMN_NAME_MESSAGE_ID => $messageId,
				ReviewNotificationMessageModel::COLUMN_NAME_CHAT_ID    => $chatId,
				ReviewNotificationMessageModel::COLUMN_NAME_REVIEW_ID  => $reviewId,
			]
		);

		self::assertNotEmpty($this->repository->getByReviewId($reviewId));
	}
}
