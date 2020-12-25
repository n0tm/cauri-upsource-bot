<?php

namespace App\Domain\Implementation\Action\Telegram;

use App\Domain\Contract;

class ContextFactory implements Contract\Action\Telegram\ContextFactory
{
	public function createUpdateReviewNotificationMessage(
		int $chatId,
		int $messageId,
		string $reviewId
	): Contract\Action\Telegram\Context\UpdateReviewNotificationMessage {
		return new Context\UpdateReviewNotificationMessage($chatId, $messageId, $reviewId);
	}

	public function createNotifyReviewersAboutAllDoneDiscussions(
		Contract\Record\Upsource\Review $review
	): Contract\Action\Telegram\Context\NotifyReviewersAboutAllDoneDiscussions {
		return new Context\NotifyReviewersAboutAllDoneDiscussions($review);
	}

	public function createDeleteReviewersNotificationsAboutAllDoneDiscussions(
		string $reviewId
	): Contract\Action\Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions {
		return new Context\DeleteReviewersNotificationsAboutAllDoneDiscussions($reviewId);
	}
}