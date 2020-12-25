<?php

namespace App\Domain\Contract\Api\Upsource\Response;

interface GetReviewSummaryDiscussions
{
	public function isAllWithLabelDone(): bool;
}