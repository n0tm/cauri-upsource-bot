<?php

namespace App\Domain\Contract\Action\Telegram\Context;

use App\Domain\Contract;

interface NotifyReviewersAboutAllDoneDiscussions
{
	public function getReview(): Contract\Record\Upsource\Review;
}