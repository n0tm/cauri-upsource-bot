<?php

namespace App\Api\Upsource\Request;

use App\Common\ArrayConvertible;

class GetSuggestedReviewersForReview implements ArrayConvertible
{
	private const KEY_NAME_PROJECT_ID = 'projectId';
	private const KEY_NAME_REVIEW_ID  = 'reviewId';
	private const KEY_NAME_ROLE       = 'role';
	private const KEY_NAME_LIMIT      = 'limit';

	/**
	 * @var string
	 */
	private $projectId;

	/**
	 * @var string
	 */
	private $reviewId;

	/**
	 * @var int
	 */
	private $role;

	/**
	 * @var int
	 */
	private $limit;

	public function __construct(string $projectId, string $reviewId, int $role, int $limit)
	{
		$this->projectId = $projectId;
		$this->reviewId  = $reviewId;
		$this->role      = $role;
		$this->limit     = $limit;
	}

	public function convertToArray(): array
	{
		return [
			self::KEY_NAME_REVIEW_ID => [
				self::KEY_NAME_PROJECT_ID => $this->projectId,
				self::KEY_NAME_REVIEW_ID  => $this->reviewId,
			],
			self::KEY_NAME_ROLE => $this->role,
			self::KEY_NAME_LIMIT => $this->limit,
		];
	}
}