<?php

namespace App\Domain\Implementation\Action\Telegram\Context;

use App\Domain\Contract;

class NotifyReviewersAboutAllDoneDiscussions implements Contract\Action\Telegram\Context\NotifyReviewersAboutAllDoneDiscussions
{
	/**
	 * @var Contract\Record\Upsource\Review
	 */
	private $review;

	public function __construct(Contract\Record\Upsource\Review $review)
	{
		$this->review = $review;
	}

	public function getReview(): Contract\Record\Upsource\Review
	{
		return $this->review;
	}
}