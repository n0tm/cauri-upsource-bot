<?php

namespace App\Domain\Contract\Entity\Telegram;

use App\Domain\Contract;

/**
 * Interface User
 * @package App\Domain\Contract\Entity\Telegram
 * @method Contract\Record\Telegram\User getRecord()
 */
interface User extends Contract\Entity\Basic
{
	public function getId(): int;
	public function getUserId(): int;
	public function getReviewChatId(): int;
}