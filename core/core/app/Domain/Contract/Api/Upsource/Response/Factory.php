<?php

namespace App\Domain\Contract\Api\Upsource\Response;

interface Factory
{
	public function getReviewDetails(array $data): GetReviewDetails;
	public function getUsersForReview(array $data): getUsersForReview;
	public function getUsersInfo(array $data): GetUserInfo;
	public function getReviewSummaryDiscussions(array $data): GetReviewSummaryDiscussions;
}