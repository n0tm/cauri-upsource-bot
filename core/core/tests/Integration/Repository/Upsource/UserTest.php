<?php

namespace Tests\Integration\Repository\Upsource;

use App\Repository\Upsource\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var User
	 */
	private $repository;

	protected function setUp(): void
	{
		parent::setUp();

		$this->repository = new User();
	}

	public function testGetByIdWhenRecordExists(): void
	{
		$id = $this->faker->text;
		$name = $this->faker->name;
		$projectId = $this->faker->text;
		$userId = $this->faker->randomNumber();

		$this->assertDatabaseMissing('upsource_users', [
			'id' => $id,
			'name' => $name,
			'project_id' => $projectId,
			'user_id' => $userId,
		]);

		$user = new \App\Model\Upsource\User();
		$user->id = $id;
		$user->name = $name;
		$user->project_id = $projectId;
		$user->user_id = $userId;
		$user->save();

		$this->assertDatabaseHas('upsource_users', [
			'id' => $id,
			'name' => $name,
			'project_id' => $projectId,
			'user_id' => $userId,
		]);

		$userFromRepository = $this->repository->getById($id);

		self::assertNotNull($userFromRepository);
		self::assertSame($id, $userFromRepository->getId());
		self::assertSame($name, $userFromRepository->getName());
		self::assertSame($projectId, $userFromRepository->getProjectId());
		self::assertSame($userId, $userFromRepository->getGlobalUserId());
	}

	public function testGetByIdWhenRecordNotExists(): void
	{
		$id = $this->faker->text;

		$this->assertDatabaseMissing('upsource_users', [
			'id' => $id,
		]);

		$userFromRepository = $this->repository->getById($id);

		self::assertNull($userFromRepository);
	}
}
