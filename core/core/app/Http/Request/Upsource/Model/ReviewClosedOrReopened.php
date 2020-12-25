<?php

namespace App\Http\Request\Upsource\Model;

class ReviewClosedOrReopened extends AbstractRequest
{
	private const STATE_CLOSED = 1;

	public function isClosed(): bool
	{
		return $this->getNewState() === self::STATE_CLOSED;
	}

	public function getReviewId(): string
	{
		return $this->getData()['base']['reviewId'];
	}

	private function getNewState(): int
	{
		return $this->getData()['newState'];
	}
}