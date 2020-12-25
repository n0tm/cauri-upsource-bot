<?php

namespace Tests\Unit\Domain\Implementation\Entity\Upsource;

use App\Domain\Implementation\Entity\Upsource\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Contract;

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Record\Upsource\User|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $record;

	/**
	 * @var User
	 */
	private $entity;

	protected function setUp(): void
	{
		parent::setUp();

		$this->record = $this->createMock(Contract\Record\Upsource\User::class);
		$this->entity = new User($this->record);
	}

	public function testGetRecord(): void
	{
		self::assertSame($this->record, $this->entity->getRecord());
	}

	public function testGetId(): void
	{
		$id = $this->faker->text;
		$this->record->expects(self::once())->method('getId')->willReturn($id);
		self::assertSame($id, $this->entity->getId());
	}

	public function testGetName(): void
	{
		$name = $this->faker->name;
		$this->record->expects(self::once())->method('getName')->willReturn($name);
		self::assertSame($name, $this->entity->getName());
	}

	public function testGetProjectId(): void
	{
		$projectId = $this->faker->text;
		$this->record->expects(self::once())->method('getProjectId')->willReturn($projectId);
		self::assertSame($projectId, $this->entity->getProjectId());
	}

	public function testGetGlobalUserId(): void
	{
		$globalUserId = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getUserId')->willReturn($globalUserId);
		self::assertSame($globalUserId, $this->entity->getGlobalUserId());
	}
}
