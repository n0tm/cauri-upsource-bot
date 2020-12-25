<?php

namespace Tests\Unit\Repository;

use App\Model\Telegram\User;
use App\Notifications\AllDiscussionsInReviewAreDone;
use App\Repository\Notifications;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class NotificationsSpy extends Notifications {

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

class NotificationsTest extends TestCase
{
	use WithFaker;

	/**
	 * @var NotificationsSpy
	 */
	private $repository;

	/**
	 * @var DatabaseNotification|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $model;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = $this->createMock(DatabaseNotification::class);

		$this->repository = new NotificationsSpy();
		$this->repository->setModel($this->model);
	}

	public function testIsTelegramUserNotificationAboutAllDoneDiscussionsInReviewExistsWhenExists(): void
	{
		$reviewId = $this->faker->text;

		$builder = $this->getMockBuilder(Builder::class)
			->disableOriginalConstructor()
			->onlyMethods(['where', 'get'])
			->getMock();
		$builder->expects(self::once())->method('where')
			->with(Notifications::COLUMN_NAME_TYPE, AllDiscussionsInReviewAreDone::class)
			->willReturn($builder);

		$needleDatabaseNotification = $this->createMock(DatabaseNotification::class);
		$needleDatabaseNotification->expects(self::once())
			->method('getAttribute')
			->with(Notifications::COLUMN_NAME_DATA)
			->willReturn([AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID => $reviewId]);

		$needlessDatabaseNotification = $this->createMock(DatabaseNotification::class);
		$needlessDatabaseNotification->expects(self::once())
			->method('getAttribute')
			->with(Notifications::COLUMN_NAME_DATA)
			->willReturn([AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID => $this->faker->text()]);

		/** @var Collection|MockObject $collection */
		$collection = $this->createMock(Collection::class);
		$collection->expects(self::once())
			->method('all')
			->willReturn([$needlessDatabaseNotification, $needleDatabaseNotification]);

		$builder->expects(self::once())->method('get')->willReturn($collection);

		$user = $this->createMock(User::class);
		$user->expects(self::once())->method('notifications')->willReturn($builder);

		self::assertTrue(
			$this->repository->isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists($user, $reviewId)
		);
	}

	public function testIsTelegramUserNotificationAboutAllDoneDiscussionsInReviewExistsWhenNotExists(): void
	{
		$reviewId = $this->faker->text;

		$builder = $this->getMockBuilder(Builder::class)
			->disableOriginalConstructor()
			->onlyMethods(['where', 'get'])
			->getMock();
		$builder->expects(self::once())->method('where')
			->with(Notifications::COLUMN_NAME_TYPE, AllDiscussionsInReviewAreDone::class)
			->willReturn($builder);

		$needlessDatabaseNotification = $this->createMock(DatabaseNotification::class);
		$needlessDatabaseNotification->expects(self::once())
			->method('getAttribute')
			->with(Notifications::COLUMN_NAME_DATA)
			->willReturn([AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID => $this->faker->text()]);

		/** @var Collection|MockObject $collection */
		$collection = $this->createMock(Collection::class);
		$collection->expects(self::once())
			->method('all')
			->willReturn([$needlessDatabaseNotification]);

		$builder->expects(self::once())->method('get')->willReturn($collection);

		$user = $this->createMock(User::class);
		$user->expects(self::once())->method('notifications')->willReturn($builder);

		self::assertFalse(
			$this->repository->isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists($user, $reviewId)
		);
	}

	public function testDeleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview(): void
	{
		$reviewId = $this->faker->text;

		$builder = $this->getMockBuilder(Builder::class)
			->disableOriginalConstructor()
			->onlyMethods(['where', 'get'])
			->getMock();
		$builder->expects(self::exactly(2))
			->method('where')
			->withConsecutive(
				[Notifications::COLUMN_NAME_TYPE, AllDiscussionsInReviewAreDone::class],
				[Notifications::COLUMN_NAME_NOTIFIABLE_TYPE, User::class]
			)->willReturn($builder);

		$needleDatabaseNotification = $this->createMock(DatabaseNotification::class);
		$needleDatabaseNotification->expects(self::once())
			->method('getAttribute')
			->with(Notifications::COLUMN_NAME_DATA)
			->willReturn([AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID => $reviewId]);
		$needleDatabaseNotification->expects(self::once())->method('delete')->willReturn(true);

		$needlessDatabaseNotification = $this->createMock(DatabaseNotification::class);
		$needlessDatabaseNotification->expects(self::once())
			->method('getAttribute')
			->with(Notifications::COLUMN_NAME_DATA)
			->willReturn([AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID => $this->faker->text()]);
		$needlessDatabaseNotification->expects(self::never())->method('delete');

		/** @var Collection|MockObject $collection */
		$collection = $this->createMock(Collection::class);
		$collection->expects(self::once())
			->method('all')
			->willReturn([$needleDatabaseNotification, $needlessDatabaseNotification]);

		$builder->expects(self::once())->method('get')->willReturn($collection);

		$this->model->expects(self::once())->method('newQuery')->willReturn($builder);

		$this->repository->deleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview($reviewId);
	}
}
