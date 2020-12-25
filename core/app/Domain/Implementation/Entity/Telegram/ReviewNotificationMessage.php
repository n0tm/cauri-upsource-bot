<?php

namespace App\Domain\Implementation\Entity\Telegram;

use App\Domain\Contract;
use App\Domain\Implementation;

/**
 * Class ReviewNotificationMessage
 * @package App\Domain\Implementation\Entity\Telegram
 * @property-read Contract\Record\Telegram\ReviewNotificationMessage $record
 *
 * @method Contract\Record\Telegram\ReviewNotificationMessage getRecord()
 */
class ReviewNotificationMessage extends Implementation\Entity\AbstractEntity implements Contract\Entity\Telegram\ReviewNotificationMessage
{
	public function getReviewId(): string
	{
		return $this->record->getReviewId();
	}

	public function getMessageId(): int
	{
		return $this->record->getMessageId();
	}

	public function getChatId(): int
	{
		return $this->record->getChatId();
	}
}