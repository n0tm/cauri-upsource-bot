<?php

namespace App\Domain\Implementation\Action\Upsource\Review\Context;

use App\Domain\Contract;

class Created extends Basic implements Contract\Action\Upsource\Review\Context\Created
{
	/**
	 * @var string
	 */
	private $creatorId;

	/**
	 * @var string
	 */
	private $branch;

	public function __construct(string $reviewId, string $creatorId, string $branch)
	{
		parent::__construct($reviewId);

		$this->creatorId = $creatorId;
		$this->branch    = $branch;
	}

	public function getCreatorId(): string
	{
		return $this->creatorId;
	}

	public function getBranch(): string
	{
		return $this->branch;
	}
}