<?php

namespace App\Domain\Implementation\Action\Telegram;

use App\Domain\Contract;

class NotifyReviewersAboutAllDoneDiscussions implements Contract\Action\Basic
{
	/**
	 * @var Contract\Api\Upsource\Facade
	 */
	private $apiUpsource;

	/**
	 * @var Contract\Repository\Notifications
	 */
	private $notificationsRepository;

	/**
	 * @var Contract\Notifications\Context\Review
	 */
	private $notificationContext;

	/**
	 * @var Contract\Repository\Upsource\User
	 */
	private $upsourceUserRepository;

	/**
	 * @var Contract\System\Facade
	 */
	private $config;

	public function __construct(
		Contract\Api\Upsource\Facade $apiUpsource,
		Contract\Repository\Notifications $notificationsRepository,
		Contract\Repository\Upsource\User $upsourceUserRepository,
		Contract\Notifications\Context\Review $notificationContext,
		Contract\System\Facade $config
	) {
		$this->apiUpsource             = $apiUpsource;
		$this->notificationsRepository = $notificationsRepository;
		$this->upsourceUserRepository  = $upsourceUserRepository;
		$this->notificationContext     = $notificationContext;
		$this->config                  = $config;
	}

	/**
	 * @param Contract\Action\Telegram\Context\NotifyReviewersAboutAllDoneDiscussions $context
	 */
	public function process($context): void
	{
		$review = $context->getReview();

		$upsourceUser = $review->getUpsourceUser();
		$projectId    = $upsourceUser->getProjectId();

		$reviewId = $review->getId();

		$discussions = $this->apiUpsource->getReviewSummaryDiscussions(
			$projectId,
			$reviewId
		);

		if (!$discussions->isAllWithLabelDone()) {
			return;
		}

		$reviewParticipants = $this->apiUpsource->getReviewDetails(
			$projectId,
			$reviewId
		)->getParticipants();

		foreach ($reviewParticipants as $reviewParticipant) {
			if ($reviewParticipant->isReviewer()) {
				$upsourceUserFromRepository = $this->upsourceUserRepository->getById($reviewParticipant->getId());
				if ($upsourceUserFromRepository === null) {
					continue;
				}

				$telegramUserFromRepository = $upsourceUserFromRepository->getRecord()->getUser()->getTelegram();
				$isUserWasAlreadyNotified = $this->notificationsRepository->isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists(
					$telegramUserFromRepository,
					$reviewId
				);

				if ($isUserWasAlreadyNotified) {
					return;
				}

				$reviewBranch = $review->getBranch();

				$this->notificationContext->setAuthor($upsourceUserFromRepository->getName());
				$this->notificationContext->setBranch($reviewBranch);
				$this->notificationContext->setReviewId($reviewId);
				$this->notificationContext->setTaskLink($this->config->getYoutrackUrlSite(), $reviewBranch);
				$this->notificationContext->setReviewLink($this->config->getUpsourceUrlSite(), $projectId, $reviewId);

				$telegramUserFromRepository->notifyAboutAllDoneDiscussions($this->notificationContext);
			}
		}
	}
}