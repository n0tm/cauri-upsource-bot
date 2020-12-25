<?php

namespace Tests\Integration\Model\Upsource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model;
use Tests\TestCase;

class Review extends TestCase
{
    use DatabaseTransactions;

    public function testUpsourceUserRelation(): void
    {
        /** @var Model\User $user */
        $user = factory(Model\User::class)->create();
        /** @var Model\Upsource\Review $review */
        $review = factory(Model\Upsource\Review::class)->create([
            'creator_upsource_user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Model\User::class, $review->upsourceUser);
    }
}