<?php

namespace Tests\Unit\Api\Upsource\Request;

use App\Api\Upsource\Request\GetSuggestedReviewersForReview;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetSuggestedReviewersForReviewTest extends TestCase
{
	use WithFaker;

	public function testConvertToArray(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;
		$role      = $this->faker->randomNumber();
		$limit     = $this->faker->randomNumber();

		$request = new GetSuggestedReviewersForReview($projectId, $reviewId, $role, $limit);
		$this->assertSame(
			[
				'reviewId' => [
					'projectId' => $projectId,
					'reviewId'  => $reviewId
				],
				'role'  => $role,
				'limit' => $limit
			],
			$request->convertToArray()
		);
	}
}
