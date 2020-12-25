<?php

namespace Tests\Unit\Api\Upsource\Response;

use App\Api\Upsource\Response\GetUsersForReview;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetUsersForReviewTest extends TestCase
{
	use WithFaker;

	public function testGetIds()
	{
		$ids = $this->faker->words;
		$response = [
			'result' => [
				'result' => [
					'others' => $ids,
				]
			],
		];

		$usersForReview = new GetUsersForReview($response);
		$this->assertSame(
			$ids,
			$usersForReview->getIds()
		);
	}
}
