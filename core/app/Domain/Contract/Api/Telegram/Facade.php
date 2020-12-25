<?php

namespace App\Domain\Contract\Api\Telegram;

interface Facade
{
	public function editMessageText(int $chatId, int $messageId, string $text): void;
	public function deleteMessage(int $chatId, int $messageId): void;
}