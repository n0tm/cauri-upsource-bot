<?php

namespace App\Domain\Implementation\Action\Upsource;

use App\Domain\Contract;

class ContextFactory implements Contract\Action\Upsource\ContextFactory
{
	public function createReviewCreated(string $reviewId, string $creatorId, string $branch): Contract\Action\Upsource\Review\Context\Created
	{
		return new Review\Context\Created($reviewId, $creatorId, $branch);
	}

	public function createBasic(string $reviewId): Contract\Action\Upsource\Review\Context\Basic
	{
		return new Review\Context\Basic($reviewId);
	}
}