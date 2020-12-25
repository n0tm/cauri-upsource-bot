<?php

namespace App\Domain\Contract\Api\Upsource\Request;

use App\Common\ArrayConvertible;

interface Factory
{
	public function getReviewDetails(string $projectId, string $reviewId): ArrayConvertible;
	public function getSuggestedReviewersForReview(string $projectId, string $reviewId, int $role, int $limit): ArrayConvertible;
	public function getUsersInfo(array $ids): ArrayConvertible;
	public function getReviewSummaryDiscussions(string $projectId, string $reviewId): ArrayConvertible;
}