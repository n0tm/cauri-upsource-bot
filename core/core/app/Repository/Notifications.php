<?php

namespace App\Repository;

use App\Domain\Contract;
use App\Model\Telegram\User;
use App\Notifications as Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notifications extends AbstractRepository implements Contract\Repository\Notifications
{
	public const COLUMN_NAME_TYPE            = 'type';
	public const COLUMN_NAME_DATA            = 'data';
	public const COLUMN_NAME_NOTIFIABLE_TYPE = 'notifiable_type';
	public const COLUMN_NAME_NOTIFIABLE_ID   = 'notifiable_id';

	/**
	 * @param Contract\Record\Telegram\User|User $user
	 * @param string $reviewId
	 * @return bool
	 */
	public function isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists(
		Contract\Record\Telegram\User $user,
		string $reviewId
	): bool {
		$notifications = $user->notifications()
			->where(self::COLUMN_NAME_TYPE, Notification\AllDiscussionsInReviewAreDone::class)
			->get()
			->all();

		foreach ($notifications as $notification) {
			$notificationReviewId = $notification->getAttribute(self::COLUMN_NAME_DATA)[Notification\AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID];
			if ($notificationReviewId === $reviewId) {
				return true;
			}
		}

		return false;
	}

	public function deleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview(string $reviewId): void
	{
		$this->deleteTelegramUserNotificationByReview(Notification\AllDiscussionsInReviewAreDone::class, $reviewId);
	}

	public function deleteTelegramUserNotificationAboutCreatedReview(string $reviewId): void
	{
		$this->deleteTelegramUserNotificationByReview(Notification\NewReview::class, $reviewId);
	}

	private function deleteTelegramUserNotificationByReview(string $notificationType, string $reviewId): void
	{
		$notifications = $this->getModel()
			->newQuery()
			->where(self::COLUMN_NAME_TYPE, $notificationType)
			->where(self::COLUMN_NAME_NOTIFIABLE_TYPE, User::class)
			->get()
			->all();

		foreach ($notifications as $notification) {
			$notificationReviewId = $notification->getAttribute(self::COLUMN_NAME_DATA)[Notification\AllDiscussionsInReviewAreDone::DATABASE_KEY_NAME_REVIEW_ID];
			if ($notificationReviewId === $reviewId) {
				$notification->delete();
			}
		}
	}

	/**
	 * @return Model|DatabaseNotification
	 */
	protected function getModel(): Model
	{
		return new DatabaseNotification();
	}
}
