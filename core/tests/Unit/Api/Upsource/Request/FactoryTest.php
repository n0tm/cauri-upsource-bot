<?php

namespace Tests\Unit\Api\Upsource\Request;

use App\Api\Upsource\Request;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Request\Factory
	 */
	private $factory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->factory = new Request\Factory();
	}

	public function testGetReviewDetails(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		self::assertEquals(
			new Request\GetReviewDetails($projectId, $reviewId),
			$this->factory->getReviewDetails($projectId, $reviewId)
		);
	}

	public function testGetSuggestedReviewersForReview(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;
		$role      = $this->faker->randomNumber();
		$limit     = $this->faker->randomNumber();

		self::assertEquals(
			new Request\GetSuggestedReviewersForReview($projectId, $reviewId, $role, $limit),
			$this->factory->getSuggestedReviewersForReview($projectId, $reviewId, $role, $limit)
		);
	}

	public function testGetUsersInfo(): void
	{
		$ids = $this->faker->words;

		self::assertEquals(
			new Request\GetUsersInfo($ids),
			$this->factory->getUsersInfo($ids)
		);
	}

	public function testGetReviewSummaryDiscussions(): void
	{
		$projectId = $this->faker->text;
		$reviewId  = $this->faker->text;

		self::assertEquals(
			new Request\GetReviewSummaryDiscussions($projectId, $reviewId),
			$this->factory->getReviewSummaryDiscussions($projectId, $reviewId)
		);
	}
}
