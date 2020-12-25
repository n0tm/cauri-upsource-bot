<?php

namespace Tests\Unit\Domain\Implementation\Entity;

use App\Domain\Implementation\Entity\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain\Contract;

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Record\User|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $record;

	/**
	 * @var User
	 */
	private $entity;

	protected function setUp(): void
	{
		parent::setUp();

		$this->record = $this->createMock(Contract\Record\User::class);
		$this->entity = new User($this->record);
	}

	public function testGetId(): void
	{
		$id = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getId')->willReturn($id);
		self::assertSame($id, $this->entity->getId());
	}

	public function testGetName(): void
	{
		$name = $this->faker->name;
		$this->record->expects(self::once())->method('getName')->willReturn($name);
		self::assertSame($name, $this->entity->getName());
	}

	public function testGetSurname(): void
	{
		$surname = $this->faker->lastName;
		$this->record->expects(self::once())->method('getSurname')->willReturn($surname);
		self::assertSame($surname, $this->entity->getSurname());
	}

	public function testGetEmail(): void
	{
		$email = $this->faker->email;
		$this->record->expects(self::once())->method('getEmail')->willReturn($email);
		self::assertSame($email, $this->entity->getEmail());
	}

	public function testGetRecord(): void
	{
		self::assertSame($this->record, $this->entity->getRecord());
	}
}
