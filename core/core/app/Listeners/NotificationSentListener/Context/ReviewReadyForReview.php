<?php

namespace App\Listeners\NotificationSentListener\Context;

class ReviewReadyForReview
{
	/**
	 * @var int
	 */
	private $messageId;

	/**
	 * @var int
	 */
	private $chatId;

	/**
	 * @var string
	 */
	private $reviewId;

	public function __construct(int $messageId, int $chatId, string $reviewId)
	{
		$this->messageId = $messageId;
		$this->chatId = $chatId;
		$this->reviewId = $reviewId;
	}

	public function getMessageId(): int
	{
		return $this->messageId;
	}

	public function getChatId(): int
	{
		return $this->chatId;
	}

	public function getReviewId(): string
	{
		return $this->reviewId;
	}
}