<?php

namespace Tests\Unit\Model\Upsource;

use App\Domain\Contract\Record\Upsource\User;
use App\Model\Upsource\Review;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Review
	 */
	private $model;

	public function setUp(): void
	{
		parent::setUp();

		$this->model = new Review();
	}

	public function testGetId(): void
	{
		$this->model->id = $this->faker->text;
		$this->assertEquals($this->model->id, $this->model->getId());
	}

	public function testGetCreatorUpsourceUserId(): void
	{
		$this->model->creator_upsource_user_id = $this->faker->text;
		$this->assertEquals($this->model->creator_upsource_user_id, $this->model->getCreatorUpsourceUserId());
	}

	public function testGetBranch(): void
	{
		$this->model->branch = $this->faker->text;
		$this->assertEquals($this->model->branch, $this->model->getBranch());
	}

	public function testGetUpsourceUser(): void
	{
		$this->model->upsourceUser = $this->createMock(User::class);
		$this->assertEquals($this->model->upsourceUser, $this->model->getUpsourceUser());
	}
}
