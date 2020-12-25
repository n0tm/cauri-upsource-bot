<?php

namespace App\Api\Upsource\Response;

use App\Domain\Contract;

class Factory implements Contract\Api\Upsource\Response\Factory
{
	public function getReviewDetails(array $data): Contract\Api\Upsource\Response\GetReviewDetails
	{
		return new GetReviewDetails($data);
	}

	public function getUsersForReview(array $data): Contract\Api\Upsource\Response\GetUsersForReview
	{
		return new GetUsersForReview($data);
	}

	public function getUsersInfo(array $data): Contract\Api\Upsource\Response\GetUserInfo
	{
		return new GetUsersInfo($data);
	}

	public function getReviewSummaryDiscussions(array $data): Contract\Api\Upsource\Response\GetReviewSummaryDiscussions
	{
		return new GetReviewSummaryDiscussions($data);
	}
}