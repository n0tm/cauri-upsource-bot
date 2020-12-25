<?php

namespace App\Domain\Contract\Api\Upsource;

interface Facade
{
	public function getReviewDetails(string $projectId, string $reviewId): Response\GetReviewDetails;
	public function getSuggestedReviewersForReview(string $projectId, string $reviewId): Response\GetUsersForReview;
	public function getUsersInfo(array $ids): Response\GetUserInfo;
	public function getReviewSummaryDiscussions(string $projectId, string $reviewId): Response\GetReviewSummaryDiscussions;
}