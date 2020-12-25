<?php

namespace App\Domain\Contract\Record\Telegram;

use App\Domain\Contract;

/**
 * Interface ReviewNotificationMessage
 * @package App\Domain\Contract\Record\Telegram
 *
 * @method Contract\Entity\Telegram\ReviewNotificationMessage getEntity()
 */
interface ReviewNotificationMessage extends Contract\Record\Basic
{
	public function getReviewId(): string;
	public function getMessageId(): int;
	public function getChatId(): int;
	public function getReview(): Contract\Record\Upsource\Review;
}