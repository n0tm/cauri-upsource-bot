<?php

namespace Tests\Unit\Helpers\Upsource;

use App\Helpers\Upsource\LinkGenerator;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkGeneratorTest extends TestCase
{
	use WithFaker;

	public function testGetReview(): void
	{
		$baseUrl   = $this->faker->text;
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		$expectedUrl = "$baseUrl/$projectId/review/$reviewId";
		$linkGenerator = new LinkGenerator();
		$this->assertSame($linkGenerator->getReview($baseUrl, $projectId, $reviewId), $expectedUrl);
	}
}