<?php

namespace App\Domain\Contract\Action\Upsource;

interface ContextFactory
{
	public function createReviewCreated(string $reviewId, string $creatorId, string $branch): Review\Context\Created;
	public function createBasic(string $reviewId): Review\Context\Basic;
}