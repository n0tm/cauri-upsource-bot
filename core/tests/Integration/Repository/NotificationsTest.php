<?php

namespace Tests\Integration\Repository;

use App\Model\Telegram\User;
use App\Notifications as Notification;
use App\Repository\Notifications;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
	use RefreshDatabase, WithFaker;

	/**
	 * @var Notifications
	 */
	private $repository;

	protected function setUp(): void
	{
		parent::setUp();

		$this->repository = new Notifications();
	}

	public function testIsTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists(): void
	{
		$reviewId = $this->faker->text;

		/** @var User $telegramUser */
		$telegramUser = factory(User::class, 1)->create()->first();

		self::assertFalse($this->repository->isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists($telegramUser, $reviewId));

		factory(DatabaseNotification::class, 1)->create([
             Notifications::COLUMN_NAME_TYPE            => Notification\AllDiscussionsInReviewAreDone::class,
             Notifications::COLUMN_NAME_NOTIFIABLE_TYPE => User::class,
             Notifications::COLUMN_NAME_DATA            => ['review_id' => $reviewId],
             Notifications::COLUMN_NAME_NOTIFIABLE_ID   => $telegramUser->id,
        ]);

		self::assertTrue($this->repository->isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists($telegramUser, $reviewId));
	}

	public function testDeleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview(): void
	{
		$reviewId = $this->faker->text;

		/** @var User $telegramUser */
		$telegramUser = factory(User::class, 1)->create()->first();

		factory(DatabaseNotification::class, $this->faker->numberBetween(1,20))->create([
            Notifications::COLUMN_NAME_TYPE            => Notification\AllDiscussionsInReviewAreDone::class,
            Notifications::COLUMN_NAME_NOTIFIABLE_TYPE => User::class,
            Notifications::COLUMN_NAME_DATA            => ['review_id' => $reviewId],
            Notifications::COLUMN_NAME_NOTIFIABLE_ID   => $telegramUser->id,
        ]);

		$expectedNotifications = factory(DatabaseNotification::class, $this->faker->numberBetween(1,20))->create([
             Notifications::COLUMN_NAME_TYPE            => Notification\AllDiscussionsInReviewAreDone::class,
             Notifications::COLUMN_NAME_NOTIFIABLE_TYPE => User::class,
             Notifications::COLUMN_NAME_DATA            => ['review_id' => $this->faker->text()],
             Notifications::COLUMN_NAME_NOTIFIABLE_ID   => $telegramUser->id,
        ]);

		$this->repository->deleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview($reviewId);

		$this->assertDatabaseCount('notifications', $expectedNotifications->count());
	}

	public function testDeleteTelegramUserNotificationAboutCreatedReview(): void
	{
		$reviewId = $this->faker->text;

		/** @var User $telegramUser */
		$telegramUser = factory(User::class, 1)->create()->first();

		factory(DatabaseNotification::class, $this->faker->numberBetween(1,20))->create([
            Notifications::COLUMN_NAME_TYPE            => Notification\NewReview::class,
            Notifications::COLUMN_NAME_NOTIFIABLE_TYPE => User::class,
            Notifications::COLUMN_NAME_DATA            => ['review_id' => $reviewId],
            Notifications::COLUMN_NAME_NOTIFIABLE_ID   => $telegramUser->id,
        ]);

		$expectedNotifications = factory(DatabaseNotification::class, $this->faker->numberBetween(1,20))->create([
	         Notifications::COLUMN_NAME_TYPE            => Notification\NewReview::class,
	         Notifications::COLUMN_NAME_NOTIFIABLE_TYPE => User::class,
	         Notifications::COLUMN_NAME_DATA            => ['review_id' => $this->faker->text()],
	         Notifications::COLUMN_NAME_NOTIFIABLE_ID   => $telegramUser->id,
        ]);

		$this->repository->deleteTelegramUserNotificationAboutCreatedReview($reviewId);

		$this->assertDatabaseCount('notifications', $expectedNotifications->count());
	}
}
