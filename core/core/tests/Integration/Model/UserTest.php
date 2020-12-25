<?php

namespace Tests\Integration\Model;

use App\Model;
use Tests\TestCase;

class UserTest extends TestCase
{
	public function testTelegramRelation(): void
	{
		/** @var Model\User $globalUser */
		$globalUser = factory(Model\User::class)->create();

		/** @var Model\Telegram\User $telegramUser */
		$telegramUser = factory(Model\Telegram\User::class)->create([
			'user_id' => $globalUser->id,
        ]);

		self::assertSame($globalUser->getTelegram()->getId(), $telegramUser->getId());
	}
}
