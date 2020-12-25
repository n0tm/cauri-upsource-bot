<?php

namespace App\Domain\Implementation\Action\Telegram\Context;

use App\Domain\Contract;

class UpdateReviewNotificationMessage implements Contract\Action\Telegram\Context\UpdateReviewNotificationMessage
{
	/**
	 * @var int
	 */
	private $chatId;

	/**
	 * @var int
	 */
	private $messageId;

	/**
	 * @var string
	 */
	private $reviewId;

	public function __construct(int $chatId, int $messageId, string $reviewId)
	{
		$this->chatId    = $chatId;
		$this->messageId = $messageId;
		$this->reviewId  = $reviewId;
	}

	public function getChatId(): int
	{
		return $this->chatId;
	}

	public function getMessageId(): int
	{
		return $this->messageId;
	}

	public function getReviewId(): string
	{
		return $this->reviewId;
	}
}