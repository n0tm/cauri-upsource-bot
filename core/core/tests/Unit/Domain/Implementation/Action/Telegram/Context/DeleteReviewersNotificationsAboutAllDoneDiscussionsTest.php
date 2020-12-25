<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram\Context;

use App\Domain\Implementation\Action\Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteReviewersNotificationsAboutAllDoneDiscussionsTest extends TestCase
{
	use WithFaker;

	public function testGetReviewId(): void
	{
		$reviewId = $this->faker->text;
		$context = new DeleteReviewersNotificationsAboutAllDoneDiscussions($reviewId);
		self::assertSame($reviewId, $context->getReviewId());
	}
}
