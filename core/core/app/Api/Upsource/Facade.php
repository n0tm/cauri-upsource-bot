<?php

namespace App\Api\Upsource;

use App\Domain\Contract\Api\Upsource;
use App\Domain\Contract\Api\Upsource\Response;

class Facade implements Upsource\Facade
{
	private const METHOD_URL_GET_REVIEW_DETAILS             = 'getReviewDetails';
	private const METHOD_URL_GET_USERS_FOR_REVIEW           = 'getUsersForReview';
	private const METHOD_URL_GET_USERS_INFO                 = 'getUserInfo';
	private const METHOD_URL_GET_REVIEW_SUMMARY_DISCUSSIONS = 'getReviewSummaryDiscussions';

	private const GET_USERS_FOR_REVIEW_LIMIT = 10;

	/**
	 * @var Upsource\Client
	 */
	private $client;

	/**
	 * @var Upsource\Request\Factory
	 */
	private $requestFactory;

	/**
	 * @var Upsource\Response\Factory
	 */
	private $responseFactory;

	public function __construct(
		Upsource\Client $client,
		Upsource\Request\Factory $requestFactory,
		Upsource\Response\Factory $responseFactory
	) {
		$this->client           = $client;
		$this->requestFactory   = $requestFactory;
		$this->responseFactory  = $responseFactory;
	}

	public function getReviewDetails(string $projectId, string $reviewId): Upsource\Response\GetReviewDetails
	{
		$request  = $this->requestFactory->getReviewDetails($projectId, $reviewId)->convertToArray();
		$response = $this->client->request(self::METHOD_URL_GET_REVIEW_DETAILS, $request);
		return $this->responseFactory->getReviewDetails($response);
	}

	public function getSuggestedReviewersForReview(string $projectId, string $reviewId): Upsource\Response\GetUsersForReview
	{
		$request = $this->requestFactory->getSuggestedReviewersForReview(
			$projectId,
			$reviewId,
			Upsource\Response\Object\Enum\RoleInReview::REVIEWER,
			self::GET_USERS_FOR_REVIEW_LIMIT
		)->convertToArray();
		$response = $this->client->request(self::METHOD_URL_GET_USERS_FOR_REVIEW, $request);
		return $this->responseFactory->getUsersForReview($response);
	}

	public function getUsersInfo(array $ids): Upsource\Response\GetUserInfo
	{
		$request  = $this->requestFactory->getUsersInfo($ids)->convertToArray();
		$response = $this->client->request(self::METHOD_URL_GET_USERS_INFO, $request);
		return $this->responseFactory->getUsersInfo($response);
	}

	public function getReviewSummaryDiscussions(
		string $projectId,
		string $reviewId
	): Response\GetReviewSummaryDiscussions {
		$request  = $this->requestFactory->getReviewSummaryDiscussions($projectId, $reviewId)->convertToArray();
		$response = $this->client->request(self::METHOD_URL_GET_REVIEW_SUMMARY_DISCUSSIONS, $request);
		return $this->responseFactory->getReviewSummaryDiscussions($response);
	}
}