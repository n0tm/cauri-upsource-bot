<?php

namespace Tests\Unit\Repository\Upsource;

use App\Repository\Upsource\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewSpy extends Review
{
	/**
	 * @var Model
	 */
	private $model;

	public function setModel(Model $model): void
	{
		$this->model = $model;
	}

	protected function getModel(): Model
	{
		return $this->model;
	}
}

class ReviewTest extends TestCase
{
	use WithFaker;

	/**
	 * @var ReviewSpy
	 */
	private $review;

	/**
	 * @var \App\Model\Upsource\Review|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $model;

	protected function setUp(): void
	{
		parent::setUp();

		$this->review = new ReviewSpy();
		$this->model  = $this->createMock(\App\Model\Upsource\Review::class);
		$this->review->setModel($this->model);
	}

	public function testCreate(): void
	{
		$id        = $this->faker->text;
		$creatorId = $this->faker->text;
		$branch    = $this->faker->text;

		$this->model->expects(self::once())->method('save')->willReturn(true);
		$this->model->expects(self::exactly(3))->method('setAttribute')->withConsecutive(
			[\App\Model\Upsource\Review::COLUMN_NAME_ID, $id],
			[\App\Model\Upsource\Review::COLUMN_NAME_CREATOR_UPSOURCE_USER_ID, $creatorId],
			[\App\Model\Upsource\Review::COLUMN_NAME_BRANCH, $branch]
		);

		$this->review->create($id, $creatorId, $branch);
	}

	public function testGetByIdWhenFailed(): void
	{
		$id = $this->faker->text;

		$builder = $this->createMock(\Illuminate\Database\Eloquent\Builder::class);
		$builder->expects(self::once())->method('find')->with($id);

		$this->model->expects(self::once())->method('newQuery')->willReturn($builder);

		self::assertNull($this->review->getById($id));
	}

	public function testGetByIdWhenSuccess(): void
	{
		$id = $this->faker->text;

		$entity = $this->createMock(\App\Domain\Contract\Entity\Upsource\Review::class);
		$record = $this->createMock(\App\Domain\Contract\Record\Upsource\Review::class);
		$record->expects(self::once())->method('getEntity')->willReturn($entity);


		$builder = $this->createMock(\Illuminate\Database\Eloquent\Builder::class);
		$builder->expects(self::once())->method('find')->with($id)->willReturn($record);

		$this->model->expects(self::once())->method('newQuery')->willReturn($builder);

		self::assertSame($entity, $this->review->getById($id));
	}
}