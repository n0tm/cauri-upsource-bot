<?php

namespace Tests\Unit\Domain\Implementation\Action\Upsource\Review\Context;

use App\Domain\Implementation\Action\Upsource\Review\Context\Basic;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BasicTest extends TestCase
{
	use WithFaker;

	public function testGetReviewId(): void
	{
		$reviewId = $this->faker->text;
		$context = new Basic($reviewId);
		self::assertSame($reviewId, $context->getReviewId());
	}
}
