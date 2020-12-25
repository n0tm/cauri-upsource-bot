<?php

namespace App\Domain\Contract\Entity\Telegram;

use App\Domain\Contract;

/**
 * Interface ReviewNotificationMessage
 * @package App\Domain\Contract\Entity\Telegram
 * @method Contract\Record\Telegram\ReviewNotificationMessage getRecord()
 */
interface ReviewNotificationMessage extends Contract\Entity\Basic
{
	public function getReviewId(): string;
	public function getMessageId(): int;
	public function getChatId(): int;
}