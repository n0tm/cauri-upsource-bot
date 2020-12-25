<?php

namespace App\Domain\Implementation\Action\Upsource\Review\Context;

class Basic implements \App\Domain\Contract\Action\Upsource\Review\Context\Basic
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