<?php

namespace Tests\Unit\Domain\Implementation\Action\Upsource\Review\Context;

use App\Domain\Implementation\Action\Upsource\Review\Context\Created;
use Tests\TestCase;

class CreatedTest extends TestCase
{
	private const TEST_REVIEW_ID  = '::reviewId::';
	private const TEST_CREATOR_ID = '::creatorId::';
	private const TEST_BRANCH     = '::branch::';

	/**
	 * @var Created
	 */
	private $context;

	protected function setUp(): void
	{
		parent::setUp();
		$this->context = new Created(self::TEST_REVIEW_ID, self::TEST_CREATOR_ID, self::TEST_BRANCH);
	}

	public function testGetReviewId(): void
	{
		$this->assertSame($this->context->getReviewId(), self::TEST_REVIEW_ID);
	}

	public function testGetBranch(): void
	{
		$this->assertSame($this->context->getBranch(), self::TEST_BRANCH);
	}

	public function testGetCreatorId(): void
	{
		$this->assertSame($this->context->getCreatorId(), self::TEST_CREATOR_ID);
	}
}
