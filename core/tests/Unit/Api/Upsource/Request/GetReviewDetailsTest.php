<?php

namespace Tests\Unit\Api\Upsource\Request;

use App\Api\Upsource\Request\GetReviewDetails;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetReviewDetailsTest extends TestCase
{
	use WithFaker;

	public function testConvertToArray(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		$reviewDetailsRequest = new GetReviewDetails($projectId, $reviewId);
		$this->assertSame(
			[
				'projectId' => $projectId,
				'reviewId'  => $reviewId,
			],
			$reviewDetailsRequest->convertToArray()
		);
	}
}
