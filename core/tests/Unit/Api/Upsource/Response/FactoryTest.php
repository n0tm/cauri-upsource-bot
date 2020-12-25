<?php

namespace Tests\Unit\Api\Upsource\Response;

use App\Api\Upsource\Response;
use Tests\TestCase;

class FactoryTest extends TestCase
{
	private const TEST_DATA = ['::key::' => '::value::'];

	/**
	 * @var Response\Factory
	 */
	private $factory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->factory = new Response\Factory();
	}

	public function testGetReviewDetails(): void
	{
		self::assertEquals(
			new Response\GetReviewDetails(self::TEST_DATA),
			$this->factory->getReviewDetails(self::TEST_DATA)
		);
	}

	public function testGetUsersForReview(): void
	{
		self::assertEquals(
			new Response\GetUsersForReview(self::TEST_DATA),
			$this->factory->getUsersForReview(self::TEST_DATA)
		);
	}

	public function testGetUsersInfo(): void
	{
		self::assertEquals(
			new Response\GetUsersInfo(self::TEST_DATA),
			$this->factory->getUsersInfo(self::TEST_DATA)
		);
	}

	public function testGetReviewSummaryDiscussions(): void
	{
		self::assertEquals(
			new Response\GetReviewSummaryDiscussions(self::TEST_DATA),
			$this->factory->getReviewSummaryDiscussions(self::TEST_DATA)
		);
	}
}
