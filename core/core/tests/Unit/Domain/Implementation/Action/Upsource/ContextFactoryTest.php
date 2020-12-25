<?php

namespace Tests\Unit\Domain\Implementation\Action\Upsource;

use App\Domain\Implementation\Action\Upsource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContextFactoryTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Upsource\ContextFactory
	 */
	private $contextFactory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->contextFactory = new Upsource\ContextFactory();
	}

	public function testCreateReviewCreated()
	{
		$reviewId  = $this->faker->text();
		$creatorId = $this->faker->text();
		$branch    = $this->faker->text();

		self::assertEquals(
			new Upsource\Review\Context\Created($reviewId, $creatorId, $branch),
			$this->contextFactory->createReviewCreated($reviewId, $creatorId, $branch)
		);
	}

	public function testCreateBasic()
	{
		$reviewId  = $this->faker->text();

		self::assertEquals(
			new Upsource\Review\Context\Basic($reviewId),
			$this->contextFactory->createBasic($reviewId)
		);
	}
}
