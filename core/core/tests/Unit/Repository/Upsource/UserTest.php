<?php

namespace Tests\Unit\Repository\Upsource;

use App\Repository\Upsource\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Contract;

class UserSpy extends User {

	/**
	 * @var \App\Model\Upsource\User
	 */
	private $model;

	public function setModel(\App\Model\Upsource\User $model): void
	{
		$this->model = $model;
	}

	protected function getModel(): Model
	{
		return $this->model;
	}
}

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var UserSpy
	 */
	private $repository;

	/**
	 * @var \App\Model\Upsource\User|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $record;

	protected function setUp(): void
	{
		parent::setUp();

		$this->record = $this->createMock(\App\Model\Upsource\User::class);

		$this->repository = new UserSpy();
		$this->repository->setModel($this->record);
	}

	public function testGetByIdWhenRecordExists(): void
	{
		$id = $this->faker->randomNumber();

		$entity = $this->createMock(Contract\Entity\Upsource\User::class);

		$record = $this->createMock(Contract\Record\Upsource\User::class);
		$record->expects(self::once())->method('getEntity')->willReturn($entity);

		$builder = $this->createMock(Builder::class);
		$builder->expects(self::once())->method('find')->with($id)->willReturn($record);

		$this->record->expects(self::once())
			->method('newQuery')
			->willReturn($builder);

		self::assertSame($entity, $this->repository->getById($id));
	}

	public function testGetByIdWhenRecordNotExists(): void
	{
		$id = $this->faker->randomNumber();

		$builder = $this->createMock(Builder::class);
		$builder->expects(self::once())->method('find')->with($id);

		$this->record->expects(self::once())
			->method('newQuery')
			->willReturn($builder);

		self::assertNull($this->repository->getById($id));
	}
}
