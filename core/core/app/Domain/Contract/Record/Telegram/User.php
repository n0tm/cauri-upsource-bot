<?php

namespace App\Domain\Contract\Record\Telegram;

use App\Domain\Contract;

/**
 * Interface User
 * @package App\Domain\Contract\Record\Telegram
 */
interface User extends Contract\Record\Basic
{
	public function getId(): int;
	public function getUserId(): int;
	public function getReviewChatId(): int;

	public function notifyAboutNewReview(Contract\Notifications\Context\Review $context): void;
	public function notifyAboutAllDoneDiscussions(Contract\Notifications\Context\Review $context): void;
}