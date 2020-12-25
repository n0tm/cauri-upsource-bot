<?php

namespace Tests\Unit\Domain\Implementation\Entity\Telegram;

use App\Domain\Implementation;
use App\Domain\Contract;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Record\Telegram\User|\PHPUnit\Framework\MockObject\MockObject
	 */
	private $record;

	/**
	 * @var Implementation\Entity\Telegram\User
	 */
	private $entity;

	protected function setUp(): void
	{
		parent::setUp();

		$this->record = $this->createMock(Contract\Record\Telegram\User::class);
		$this->entity = new Implementation\Entity\Telegram\User($this->record);
	}

	public function testGetId(): void
	{
		$id = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getId')->willReturn($id);
		self::assertSame($id, $this->entity->getId());
	}

	public function testGetUserId(): void
	{
		$userId = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getUserId')->willReturn($userId);
		self::assertSame($userId, $this->entity->getUserId());
	}

	public function testGetReviewChatId(): void
	{
		$reviewChatId = $this->faker->randomNumber();
		$this->record->expects(self::once())->method('getReviewChatId')->willReturn($reviewChatId);
		self::assertSame($reviewChatId, $this->entity->getReviewChatId());
	}

	public function testGetRecord(): void
	{
		self:self::assertSame($this->record, $this->entity->getRecord());
	}
}
