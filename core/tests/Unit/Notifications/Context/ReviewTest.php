<?php

namespace Tests\Unit\Notifications\Context;

use App\Helpers;
use App\Notifications\Context\Review;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Helpers\Upsource\Branch|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $branchHelper;

	/**
	 * @var Helpers\YouTrack\LinkGenerator|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $youtrackLinkGenerator;

	/**
	 * @var Helpers\Upsource\LinkGenerator|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $upsourceLinkGenerator;

	/**
	 * @var Review
	 */
	private $context;

	protected function setUp(): void
	{
		parent::setUp();

		$this->branchHelper          = $this->createMock(Helpers\Upsource\Branch::class);
		$this->youtrackLinkGenerator = $this->createMock(Helpers\Youtrack\LinkGenerator::class);
		$this->upsourceLinkGenerator = $this->createMock(Helpers\Upsource\LinkGenerator::class);

		$this->context = new Review($this->upsourceLinkGenerator, $this->youtrackLinkGenerator, $this->branchHelper);
	}

	public function testSetAndGetReviewLink(): void
	{
		$upsourceSiteUrl = $this->faker->url;
		$projectId       = $this->faker->text;
		$reviewId        = $this->faker->text;
		$reviewLink      = $this->faker->url;

		$this->upsourceLinkGenerator->expects(self::once())
			->method('getReview')
			->with($upsourceSiteUrl, $projectId, $reviewId)
			->willReturn($reviewLink);

		$this->context->setReviewLink($upsourceSiteUrl, $projectId, $reviewId);

		self::assertSame($reviewLink, $this->context->getReviewLink());
	}

	public function testSetAndGetTaskLinkWhenBranchValid(): void
	{
		$branch          = $this->faker->text;
		$taskId          = $this->faker->text;
		$youtrackSiteUrl = $this->faker->url;
		$taskLink        = $this->faker->url;

		$this->branchHelper->expects(self::once())->method('getTaskId')->with($branch)->willReturn($taskId);
		$this->youtrackLinkGenerator->expects(self::once())
			->method('getTask')
			->with($youtrackSiteUrl, $taskId)
			->willReturn($taskLink);

		$this->context->setTaskLink($youtrackSiteUrl, $branch);

		self::assertSame($taskLink, $this->context->getTaskLink());
	}

	public function testSetAndGetTaskLinkWhenBranchInvalid(): void
	{
		$branch          = $this->faker->text;
		$youtrackSiteUrl = $this->faker->url;

		$this->branchHelper->expects(self::once())->method('getTaskId')->with($branch);
		$this->youtrackLinkGenerator->expects(self::never())
			->method('getTask');

		$this->context->setTaskLink($youtrackSiteUrl, $branch);

		self::assertNull($this->context->getTaskLink());
	}

	public function testSetAndGetReviewId(): void
	{
		$reviewId = $this->faker->text;
		$this->context->setReviewId($reviewId);
		self::assertSame($reviewId, $this->context->getReviewId());
	}
}
