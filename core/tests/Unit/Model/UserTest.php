<?php

namespace Tests\Unit\Model;

use App\Model;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use App\Domain\Contract;

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Model\User
	 */
	private $model;

	protected function setUp(): void
	{
		parent::setUp();

		$this->model = new Model\User();
	}

	public function testTelegramRelation(): void
	{
		$telegramUser = $this->createMock(Model\Telegram\User::class);

		/** @var Model\User|MockObject $model */
		$model = $this->getMockBuilder(Model\User::class)->setMethodsExcept(['telegram'])->getMock();
		$model->expects(self::once())->method('hasOne')
			->with(Model\Telegram\User::class)
			->willReturn($telegramUser);

		self::assertSame($telegramUser, $model->telegram());
	}

	public function testGetEntity(): void
	{
		self::assertEquals(new \App\Domain\Implementation\Entity\User($this->model), $this->model->getEntity());
	}

	public function testGetId(): void
	{
		$id = $this->faker->randomNumber();
		$this->model->id = $id;
		self::assertSame($id, $this->model->getId());
	}

	public function testGetName(): void
	{
		$name = $this->faker->name;
		$this->model->name = $name;
		self::assertSame($name, $this->model->getName());
	}

	public function testGetSurname(): void
	{
		$surname = $this->faker->lastName;
		$this->model->surname = $surname;
		self::assertSame($surname, $this->model->getSurname());
	}

	public function testGetEmail(): void
	{
		$email = $this->faker->email;
		$this->model->email = $email;
		self::assertSame($email, $this->model->getEmail());
	}

	public function testGetTelegram(): void
	{
		$telegramUser = $this->createMock(Contract\Record\Telegram\User::class);
		$this->model->telegram = $telegramUser;
		self::assertSame($telegramUser, $this->model->getTelegram());
	}
}
