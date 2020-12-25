<?php

namespace App\Domain\Implementation\Entity\Telegram;

use App\Domain\Contract;
use App\Domain\Implementation;

/**
 * Class User
 * @package App\Domain\Implementation\Entity\Telegram
 * @property-read Contract\Record\Telegram\User $record
 *
 * @method Contract\Record\Telegram\User getRecord()
 */
class User extends Implementation\Entity\AbstractEntity implements Contract\Entity\Telegram\User
{
	public function getId(): int
	{
		return $this->record->getId();
	}

	public function getUserId(): int
	{
		return $this->record->getUserId();
	}

	public function getReviewChatId(): int
	{
		return $this->record->getReviewChatId();
	}
}