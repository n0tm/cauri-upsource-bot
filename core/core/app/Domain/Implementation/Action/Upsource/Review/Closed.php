<?php

namespace App\Domain\Implementation\Action\Upsource\Review;

use App\Domain\Contract;

class Closed implements Contract\Action\Basic
{
	/**
	 * @var Contract\Repository\Telegram\ReviewNotificationMessage
	 */
	private $reviewNotificationMessageRepository;

	/**
	 * @var Contract\Api\Telegram\Facade
	 */
	private $apiTelegram;

	public function __construct(
		Contract\Repository\Telegram\ReviewNotificationMessage $reviewNotificationMessageRepository,
		Contract\Api\Telegram\Facade $apiTelegram
	) {
		$this->reviewNotificationMessageRepository = $reviewNotificationMessageRepository;
		$this->apiTelegram = $apiTelegram;
	}

	/**
	 * @param Contract\Action\Upsource\Review\Context\Basic $context
	 * @throws \Exception
	 */
	public function process($context): void
	{
		$telegramReviewNotificationMessage = $this->reviewNotificationMessageRepository->getByReviewId($context->getReviewId());
		if ($telegramReviewNotificationMessage === null) {
			return;
		}

		$this->apiTelegram->deleteMessage(
			$telegramReviewNotificationMessage->getChatId(),
			$telegramReviewNotificationMessage->getMessageId()
		);

		$telegramReviewNotificationMessageRecord = $telegramReviewNotificationMessage->getRecord();
		$telegramReviewNotificationMessageRecord->getReview()->delete();
		$telegramReviewNotificationMessageRecord->delete();
	}
}