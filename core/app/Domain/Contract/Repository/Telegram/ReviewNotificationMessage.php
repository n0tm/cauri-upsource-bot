<?php

namespace App\Domain\Contract\Repository\Telegram;

use App\Domain\Contract;

interface ReviewNotificationMessage
{
	public function create(int $messageId, int $chatId, string $reviewId): bool;
	public function isExistsByReviewId(string $id): bool;
	public function getByReviewId(string $id): ?Contract\Entity\Telegram\ReviewNotificationMessage;
}