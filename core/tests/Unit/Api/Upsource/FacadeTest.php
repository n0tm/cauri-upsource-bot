<?php

namespace Tests\Unit\Api\Upsource;

use App\Api\Upsource;
use App\Common\ArrayConvertible;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use App\Domain\Contract;

class FacadeTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Api\Upsource\Client|MockObject
	 */
	private $client;

	/**
	 * @var Contract\Api\Upsource\Request\Factory|MockObject
	 */
	private $requestFactory;

	/**
	 * @var Contract\Api\Upsource\Response\Factory|MockObject
	 */
	private $responseFactory;

	/**
	 * @var Upsource\Facade
	 */
	private $facade;

	protected function setUp(): void
	{
		parent::setUp();

		$this->client          = $this->createMock(Contract\Api\Upsource\Client::class);
		$this->requestFactory  = $this->createMock(Contract\Api\Upsource\Request\Factory::class);
		$this->responseFactory = $this->createMock(Contract\Api\Upsource\Response\Factory::class);

		$this->facade = new Upsource\Facade($this->client, $this->requestFactory, $this->responseFactory);
	}

	public function testGetReviewDetails(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		$request = $this->createMock(ArrayConvertible::class);
		$convertedRequest = ['::key::' => '::value::'];
		$request->expects($this->once())
			->method('convertToArray')
			->willReturn($convertedRequest);

		$this->client->expects($this->once())
			->method('request')
			->with('getReviewDetails', $convertedRequest)
			->willReturn($convertedRequest);

		$this->requestFactory->expects($this->once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($request);
		$this->responseFactory->expects($this->once())
			->method('getReviewDetails')
			->with($convertedRequest);

		$this->facade->getReviewDetails($projectId, $reviewId);
	}

	public function testGetUsersInfo(): void
	{
		$ids = $this->faker->words;

		$request = $this->createMock(ArrayConvertible::class);
		$convertedRequest = ['::key::' => '::value::'];
		$request->expects($this->once())
			->method('convertToArray')
			->willReturn($convertedRequest);

		$this->client->expects($this->once())
			->method('request')
			->with('getUserInfo', $convertedRequest)
			->willReturn($convertedRequest);

		$this->requestFactory->expects($this->once())
			->method('getUsersInfo')
			->with($ids)
			->willReturn($request);
		$this->responseFactory->expects($this->once())
			->method('getUsersInfo')
			->with($convertedRequest);

		$this->facade->getUsersInfo($ids);
	}

	public function testGetSuggestedReviewersForReview(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		$request = $this->createMock(ArrayConvertible::class);
		$convertedRequest = ['::key::' => '::value::'];
		$request->expects($this->once())
			->method('convertToArray')
			->willReturn($convertedRequest);

		$this->client->expects($this->once())
			->method('request')
			->with('getUsersForReview', $convertedRequest)
			->willReturn($convertedRequest);

		$this->requestFactory->expects($this->once())
			->method('getSuggestedReviewersForReview')
			->with($projectId, $reviewId, Contract\Api\Upsource\Response\Object\Enum\RoleInReview::REVIEWER, 10)
			->willReturn($request);
		$this->responseFactory->expects($this->once())
			->method('getUsersForReview')
			->with($convertedRequest);

		$this->facade->getSuggestedReviewersForReview($projectId, $reviewId);
	}

	public function testGetReviewSummaryDiscussions(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		$request = $this->createMock(ArrayConvertible::class);
		$convertedRequest = ['::key::' => '::value::'];
		$request->expects($this->once())
			->method('convertToArray')
			->willReturn($convertedRequest);

		$this->client->expects($this->once())
			->method('request')
			->with('getReviewSummaryDiscussions', $convertedRequest)
			->willReturn($convertedRequest);

		$this->requestFactory->expects($this->once())
			->method('getReviewSummaryDiscussions')
			->with($projectId, $reviewId)
			->willReturn($request);
		$this->responseFactory->expects($this->once())
			->method('getReviewSummaryDiscussions')
			->with($convertedRequest);

		$this->facade->getReviewSummaryDiscussions($projectId, $reviewId);
	}
}
