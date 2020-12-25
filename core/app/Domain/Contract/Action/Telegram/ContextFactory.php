<?php

namespace App\Domain\Contract\Action\Telegram;

use App\Domain\Contract;

interface ContextFactory
{
	public function createUpdateReviewNotificationMessage(int $chatId, int $messageId, string $reviewId): Context\UpdateReviewNotificationMessage;
	public function createNotifyReviewersAboutAllDoneDiscussions(Contract\Record\Upsource\Review $review): Context\NotifyReviewersAboutAllDoneDiscussions;
	public function createDeleteReviewersNotificationsAboutAllDoneDiscussions(string $reviewId): Context\DeleteReviewersNotificationsAboutAllDoneDiscussions;
}