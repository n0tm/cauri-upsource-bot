<?php

namespace Tests\Unit\Model\Telegram;

use App\Model\Telegram\User;
use App\Notifications;
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

	public function testGetEntity(): void
	{
		self::assertEquals(new \App\Domain\Implementation\Entity\Telegram\User($this->model), $this->model->getEntity());
	}

	public function testGetId(): void
	{
		$id = $this->faker->randomNumber();
		$this->model->id = $id;
		self::assertSame($id, $this->model->getId());
	}

	public function testGetUserId(): void
	{
		$userId = $this->faker->randomNumber();
		$this->model->user_id = $userId;
		self::assertSame($userId, $this->model->getUserId());
	}

	public function testGetReviewChatId(): void
	{
		$reviewChatId = $this->faker->randomNumber();
		$this->model->review_chat_id = $reviewChatId;
		self::assertSame($reviewChatId, $this->model->getReviewChatId());
	}

	public function testNotifyAboutNewReview(): void
	{
		$context = $this->createMock(Contract\Notifications\Context\Review::class);
		$notification = $this->createMock(Notifications\NewReview::class);
		$notification->expects(self::once())->method('setContext')->with($context);

		$this->instance(Notifications\NewReview::class, $notification);

		/** @var User|MockObject $model */
		$model = $this->getMockBuilder(User::class)->setMethodsExcept(['notifyAboutNewReview'])->getMock();
		$model->expects(self::once())->method('notify')->with($notification);

		$model->notifyAboutNewReview($context);
	}

	public function testNotifyAboutAllDoneDiscussions(): void
	{
		$context = $this->createMock(Contract\Notifications\Context\Review::class);
		$notification = $this->createMock(Notifications\AllDiscussionsInReviewAreDone::class);
		$notification->expects(self::once())->method('setContext')->with($context);

		$this->instance(Notifications\AllDiscussionsInReviewAreDone::class, $notification);

		/** @var User|MockObject $model */
		$model = $this->getMockBuilder(User::class)->setMethodsExcept(['notifyAboutAllDoneDiscussions'])->getMock();
		$model->expects(self::once())->method('notify')->with($notification);

		$model->notifyAboutAllDoneDiscussions($context);
	}
}
