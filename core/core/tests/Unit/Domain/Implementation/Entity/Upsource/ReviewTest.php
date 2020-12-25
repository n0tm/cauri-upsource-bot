<?php

namespace Tests\Unit\Domain\Implementation\Entity\Upsource;

use App\Domain\Implementation\Entity\Upsource\Review;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Review
	 */
	private $entity;

	/**
	 * @var \App\Domain\Contract\Record\Upsource\Review|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $record;

	public function setUp(): void
	{
		parent::setUp();

		$this->record = $this->createMock(\App\Domain\Contract\Record\Upsource\Review::class);
		$this->entity = new Review($this->record);
	}

	public function testGetId(): void
	{
		$id = $this->faker->text;
		$this->record->expects($this->once())->method('getId')->willReturn($id);
		self::assertSame($id, $this->entity->getId());
	}

	public function testGetCreatorUpsourceUserId(): void
	{
		$creatorUpsourceUserId = $this->faker->text;
		$this->record->expects($this->once())->method('getCreatorUpsourceUserId')->willReturn($creatorUpsourceUserId);
		self::assertSame($creatorUpsourceUserId, $this->entity->getCreatorUpsourceUserId());
	}

	public function testGetBranch(): void
	{
		$branch = $this->faker->text;
		$this->record->expects($this->once())->method('getBranch')->willReturn($branch);
		self::assertSame($branch, $this->entity->getBranch());
	}

	public function testGetRecord(): void
	{
		self::assertSame(
			$this->record,
			$this->entity->getRecord()
		);
	}
}
