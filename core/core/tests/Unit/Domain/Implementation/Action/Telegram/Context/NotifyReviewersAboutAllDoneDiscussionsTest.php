<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram\Context;

use App\Domain\Implementation\Action\Telegram\Context\NotifyReviewersAboutAllDoneDiscussions;
use Tests\TestCase;
use App\Domain\Contract;

class NotifyReviewersAboutAllDoneDiscussionsTest extends TestCase
{
	public function testGetReview(): void
	{
		$review = $this->createMock(Contract\Record\Upsource\Review::class);
		$context = new NotifyReviewersAboutAllDoneDiscussions($review);
		self::assertSame($review, $context->getReview());
	}
}
