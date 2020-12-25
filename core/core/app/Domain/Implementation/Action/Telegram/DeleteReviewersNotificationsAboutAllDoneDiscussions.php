<?php

namespace App\Domain\Implementation\Action\Telegram;

use App\Domain\Contract;

class DeleteReviewersNotificationsAboutAllDoneDiscussions implements Contract\Action\Basic
{
	/**
	 * @var Contract\Repository\Notifications
	 */
	private $notificationsRepository;

	public function __construct(Contract\Repository\Notifications $notificationsRepository)
	{
		$this->notificationsRepository = $notificationsRepository;
	}

	/**
	 * @param Contract\Action\Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions $context
	 */
	public function process($context): void
	{
		$reviewId = $context->getReviewId();
		$this->notificationsRepository->deleteTelegramUsersNotificationsAboutAllDoneDiscussionsInReview($reviewId);
	}
}