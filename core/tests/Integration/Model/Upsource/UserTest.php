<?php

namespace Tests\Integration\Model\Upsource;

use Tests\TestCase;

class UserTest extends TestCase
{
	public function testGetUserRelation(): void
	{
		/** @var \App\Model\User $user */
		$user = factory(\App\Model\User::class)->create();

		/** @var \App\Model\Upsource\User  $upsourceUser */
		$upsourceUser = factory(\App\Model\Upsource\User::class)->create([
			'user_id' => $user->id
        ]);

		$this->assertSame($user->getId(), $upsourceUser->getUser()->getId());
	}
}
