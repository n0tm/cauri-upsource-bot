<?php

namespace App\Api\Upsource\Request;

use App\Common\ArrayConvertible;
use App\Domain\Contract;

class Factory implements Contract\Api\Upsource\Request\Factory
{
	public function getReviewDetails(string $projectId, string $reviewId): ArrayConvertible
	{
		return new GetReviewDetails($projectId, $reviewId);
	}

	public function getSuggestedReviewersForReview(string $projectId, string $reviewId, int $role, int $limit): ArrayConvertible
	{
		return new GetSuggestedReviewersForReview($projectId, $reviewId, $role, $limit);
	}

	public function getUsersInfo(array $ids): ArrayConvertible
	{
		return new GetUsersInfo($ids);
	}

	public function getReviewSummaryDiscussions(string $projectId, string $reviewId): ArrayConvertible
	{
		return new GetReviewSummaryDiscussions($projectId, $reviewId);
	}
}