<?php

namespace App\Domain\Implementation\Action\Telegram\Context;

use App\Domain\Contract;

class DeleteReviewersNotificationsAboutAllDoneDiscussions implements
	Contract\Action\Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions
{
	/**
	 * @var string
	 */
	private $reviewId;

	public function __construct(string $reviewId)
	{
		$this->reviewId = $reviewId;
	}

	public function getReviewId(): string
	{
		return $this->reviewId;
	}
}