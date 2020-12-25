<?php

namespace App\Api\Upsource\Request;

use App\Common\ArrayConvertible;

class GetReviewDetails implements ArrayConvertible
{
	private const KEY_NAME_PROJECT_ID = 'projectId';
	private const KEY_NAME_REVIEW_ID  = 'reviewId';

	/**
	 * @var string
	 */
	private $projectId;

	/**
	 * @var string
	 */
	private $reviewId;

	public function __construct(string $projectId, string $reviewId)
	{
		$this->projectId = $projectId;
		$this->reviewId  = $reviewId;
	}

	public function convertToArray(): array
	{
		return [
			self::KEY_NAME_PROJECT_ID => $this->projectId,
			self::KEY_NAME_REVIEW_ID  => $this->reviewId,
		];
	}
}