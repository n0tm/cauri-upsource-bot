<?php

namespace Tests\Integration\Model\Upsource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReviewTest extends TestCase
{
	use DatabaseTransactions;

	public function testUpsourceUserRelation(): void
	{
		/** @var \App\Model\User  $upsourceUser */
		$upsourceUser = factory(\App\Model\Upsource\User::class)->create();

		/** @var \App\Model\Upsource\Review $review */
		$review = factory(\App\Model\Upsource\Review::class)->create([
            'creator_upsource_user_id' => $upsourceUser->id
        ]);
		
		$this->assertEquals($upsourceUser->id, $review->upsourceUser->id);
	}
}
