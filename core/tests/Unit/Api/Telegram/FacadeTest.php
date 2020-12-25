<?php

namespace Tests\Unit\Api\Telegram;

use App\Api\Telegram\Facade;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Telegram\Bot\Api;

class FacadeTest extends TestCase
{
	use WithFaker;

	/**
	 * @var \PHPUnit\Framework\MockObject\MockObject|Api
	 */
	private $client;

	/**
	 * @var Facade
	 */
	private $facade;

	protected function setUp(): void
	{
		parent::setUp();

		$this->client = $this->createMock(Api::class);
		$this->facade = new Facade($this->client);
	}

	public function testEditMessageText(): void
	{
		$chatId = $this->faker->randomNumber();
		$messageId = $this->faker->randomNumber();
		$text = $this->faker->text();

		$this->client->expects($this->once())
			->method('editMessageText')
			->with([
	            'chat_id'    => $chatId,
		        'message_id' => $messageId,
		        'text'       => $text,
	        ]);

		$this->facade->editMessageText($chatId, $messageId, $text);
	}

	public function testDeleteMessage(): void
	{
		$chatId = $this->faker->randomNumber();
		$messageId = $this->faker->randomNumber();

		$this->client->expects($this->once())
			->method('deleteMessage')
			->with([
		        'chat_id'    => $chatId,
		        'message_id' => $messageId,
	        ]);

		$this->facade->deleteMessage($chatId, $messageId);
	}
}
