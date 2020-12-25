<?php

namespace App\Domain\Implementation\Action\Telegram;

use App\Domain\Contract;

class UpdateReviewNotificationMessage implements Contract\Action\Basic
{
	/**
	 * @var Contract\Api\Telegram\Facade
	 */
	private $telegramClient;

	/**
	 * @var Contract\Api\Upsource\Facade
	 */
	private $upsourceClient;

	/**
	 * @var Contract\Repository\Upsource\Review
	 */
	private $reviewRepository;

	/**
	 * @var Contract\Repository\Upsource\User
	 */
	private $upsourceUserRepository;

	/**
	 * @var Contract\Notifications\Message\Component\NewReview
	 */
	private $reviewMessage;

	public function __construct(
		Contract\Api\Telegram\Facade $telegramClient,
		Contract\Api\Upsource\Facade $upsourceClient,
		Contract\Repository\Upsource\Review $reviewRepository,
		Contract\Repository\Upsource\User $upsourceUserRepository,
		Contract\Notifications\Message\Component\NewReview $reviewMessage
	) {
		$this->telegramClient         = $telegramClient;
		$this->upsourceClient         = $upsourceClient;
		$this->reviewRepository       = $reviewRepository;
		$this->upsourceUserRepository = $upsourceUserRepository;
		$this->reviewMessage          = $reviewMessage;
	}

	/**
	 * @param Contract\Action\Telegram\Context\UpdateReviewNotificationMessage $context
	 */
	public function process($context): void
	{
		$review = $this->reviewRepository->getById($context->getReviewId());

		$upsourceUser = $review->getRecord()->getUpsourceUser();
		$globalUser   = $upsourceUser->getUser();
		$projectId    = $upsourceUser->getProjectId();

		$reviewDetails      = $this->upsourceClient->getReviewDetails($projectId, $context->getReviewId());
		$suggestedReviewers = $this->upsourceClient->getSuggestedReviewersForReview($projectId, $context->getReviewId());

		$this->reviewMessage->setTitle(sprintf('Ревью: %s', $review->getId()))
			->setAuthor(sprintf('%s %s', $globalUser->getName(), $globalUser->getSurname()))
			->setBranch($review->getBranch())
			->setDescription($reviewDetails->getDescription())
			->setTotalDiscussionsCount($reviewDetails->getDiscussionsCount())
			->setResolvedDiscussionsCount($reviewDetails->getResolvedDiscussionsCount())
			->setIsReadyToClose($reviewDetails->isReadyToClose());


		$suggestedReviewersInfo = $this->upsourceClient->getUsersInfo($suggestedReviewers->getIds())->getInfos();
		foreach ($suggestedReviewersInfo as $fullUserInfo) {
			$this->reviewMessage->addSuggestedReviewer($fullUserInfo->getName());
		}

		foreach ($reviewDetails->getParticipants() as $participant) {
			if (!$participant->isReviewer()) {
				continue;
			}

			$participantFromRepository = $this->upsourceUserRepository->getById($participant->getId());
			if ($participantFromRepository !== null) {
				$this->reviewMessage->addRecipient($participantFromRepository->getName(), $participant->getState());
			} else {
				$participantInfo = $this->upsourceClient->getUsersInfo([$participant->getId()])->getInfos();
				$this->reviewMessage->addRecipient($participantInfo[0]->getName(), $participant->getState());
			}
		}

		$this->telegramClient->editMessageText($context->getChatId(), $context->getMessageId(), $this->reviewMessage->toString());
	}
}