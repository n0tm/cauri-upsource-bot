<?php

namespace App\Domain\Contract\Action\Telegram\Context;

interface UpdateReviewNotificationMessage
{
	public function getChatId(): int;
	public function getMessageId(): int;
	public function getReviewId(): string;
}