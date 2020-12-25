<?php

namespace Tests\Unit\Notifications\Message\Component;

use App\Notifications\Message\Component;
use Tests\TestCase;

class FactoryTest extends TestCase
{
	/**
	 * @var Component\Factory
	 */
	private $factory;

	protected function setUp(): void
	{
		parent::setUp();

		$this->factory = new Component\Factory();
	}

	public function testCreateReview()
	{
		self::assertEquals(new Component\NewReview(), $this->factory->createReview());
	}

	public function testCreateAllDiscussionsInReviewAreDone()
	{
		self::assertEquals(new Component\AllDiscussionsInReviewAreDone(), $this->factory->createAllDiscussionsInReviewAreDone());
	}
}
