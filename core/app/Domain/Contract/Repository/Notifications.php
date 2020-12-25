<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Contract;

interface Notifications
{
	public function isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists(
		Contract\Record\Telegram\User $user,
		string $reviewId
	): bool;

	public function deleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview(string $reviewId): void;
	public function deleteTelegramUserNotificationAboutCreatedReview(string $reviewId): void;
}