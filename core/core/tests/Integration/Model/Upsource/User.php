<?php

namespace Tests\Integration\Model\Upsource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class User extends TestCase
{
    use DatabaseTransactions;

    public function testGetUserRelation(): void
    {
        /** @var \App\Model\User  $globalUser */
        $globalUser = factory(\App\Model\User::class)->create();
        /** @var \App\Model\Upsource\User $user */
        $upsourceUser = factory(\App\Model\Upsource\User::class)->create([
            'user_id' => $globalUser->id
        ]);
        $this->assertEquals($globalUser->id, $upsourceUser->user->id);
    }
}