<?php

namespace Tests\Unit\Api\Upsource\Request;

use App\Api\Upsource\Request\GetReviewSummaryDiscussions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetReviewSummaryDiscussionsTest extends TestCase
{
	use WithFaker;

	public function testConvertToArray()
	{
		$projectId = $this->faker->text();
		$reviewId = $this->faker->text();

		$expectedConvertedRequest = [
			'reviewId'  => [
				'projectId' => $projectId,
				'reviewId'  => $reviewId,
			],
			'revisions' => [
				'selectAll' => true,
			],
		];

		$actualRequest = new GetReviewSummaryDiscussions($projectId, $reviewId);
		self::assertSame($expectedConvertedRequest, $actualRequest->convertToArray());
	}
}
