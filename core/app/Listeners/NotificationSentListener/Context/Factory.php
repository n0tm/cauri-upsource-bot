<?php

namespace App\Listeners\NotificationSentListener\Context;

class Factory
{
	public function createReviewReadyForReview(int $messageId, int $chatId, string $reviewId): ReviewReadyForReview
	{
		return new ReviewReadyForReview($messageId, $chatId, $reviewId);
	}
}