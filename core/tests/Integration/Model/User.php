<?php

namespace Tests\Integration\Model;

use App\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class User extends TestCase
{
    use DatabaseTransactions;

    public function testTelegramRelation(): void
    {
        /** @var \App\Model\User $user */
        $user = factory(Model\User::class)->create();
        factory(Model\TelegramUser::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Model\TelegramUser::class, $user->telegram);
        $this->assertEquals(1, $user->telegram->count());
    }
}