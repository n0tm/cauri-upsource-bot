<?php

namespace App\Api\Telegram;

use Telegram\Bot\Api;

class Facade implements \App\Domain\Contract\Api\Telegram\Facade
{
	/**
	 * @var Api
	 */
	private $client;

	public function __construct(Api $client)
	{
		$this->client = $client;
	}

	public function editMessageText(int $chatId, int $messageId, string $text): void
	{
		$this->client->editMessageText([
            'chat_id'    => $chatId,
            'message_id' => $messageId,
            'text'       => $text,
        ]);
	}

	public function deleteMessage(int $chatId, int $messageId): void
	{
		$this->client->deleteMessage([
			'chat_id'    => $chatId,
			'message_id' => $messageId,
        ]);
	}
}