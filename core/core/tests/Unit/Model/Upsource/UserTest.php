<?php

namespace Tests\Unit\Model\Upsource;

use App\Model\Upsource\User;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use App\Domain\Contract;

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var User
	 */
	private $model;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = new User();
	}

	public function testUserRelation(): void
	{
		/** @var User|MockObject $model */
		$model = $this->getMockBuilder(User::class)->setMethodsExcept(['user'])->getMock();
		$model->expects(self::once())->method('belongsTo')
			->with(\App\Model\User::class)
			->willReturn($this->createMock(User::class));

		$model->user();
	}

	public function testGetEntity(): void
	{
		self::assertEquals(new \App\Domain\Implementation\Entity\Upsource\User($this->model), $this->model->getEntity());
	}

	public function testGetId(): void
	{
		$id = $this->faker->text;
		$this->model->id = $id;
		self::assertSame($id, $this->model->getId());
	}

	public function testGetName(): void
	{
		$name = $this->faker->name;
		$this->model->name = $name;
		self::assertSame($name, $this->model->getName());
	}

	public function testGetProjectId(): void
	{
		$projectId = $this->faker->text;
		$this->model->project_id = $projectId;
		self::assertSame($projectId, $this->model->getProjectId());
	}

	public function getUserId(): void
	{
		$userId = $this->faker->randomNumber();
		$this->model->user_id = $userId;
		self::assertSame($userId, $this->model->getUserId());
	}

	public function getUser(): void
	{
		$user = $this->createMock(Contract\Record\User::class);
		$this->model->user = $user;
		self::assertSame($user, $this->model->getUser());
	}
}
