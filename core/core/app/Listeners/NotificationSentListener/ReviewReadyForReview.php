<?php

namespace App\Listeners\NotificationSentListener;

use App\Domain\Contract\Repository\Telegram\ReviewNotificationMessage;
use App\Listeners\Listener;

class ReviewReadyForReview implements Listener
{
	/**
	 * @var ReviewNotificationMessage
	 */
	private $repository;

	public function __construct(ReviewNotificationMessage $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param Context\ReviewReadyForReview $context
	 */
	public function handle($context): void
	{
		$this->repository->create(
			$context->getMessageId(),
			$context->getChatId(),
			$context->getReviewId()
		);
	}
}