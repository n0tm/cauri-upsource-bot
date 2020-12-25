<?php

namespace Tests\Unit\Domain\Implementation\Action\Upsource\Review;

use App\Common\ExceptionWithContext;
use App\Domain\Implementation\Action\Upsource\Review\Created;
use App\Domain\Contract;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreatedTest extends TestCase
{
	/**
	 * @var Contract\Repository\Upsource\User|MockObject
	 */
	private $upsourceUserRepository;

	/**
	 * @var Contract\System\Facade|MockObject
	 */
	private $config;

	/**
	 * @var Contract\Repository\Upsource\Review|MockObject
	 */
	private $reviewRepository;

	/**
	 * @var Contract\Notifications\Context\Review|MockObject
	 */
	private $notificationContext;

	/**
	 * @var Created
	 */
	private $action;

	protected function setUp(): void
	{
		parent::setUp();

		$this->upsourceUserRepository = $this->createMock(Contract\Repository\Upsource\User::class);
		$this->config                 = $this->createMock(Contract\System\Facade::class);
		$this->reviewRepository       = $this->createMock(Contract\Repository\Upsource\Review::class);
		$this->notificationContext    = $this->createMock(Contract\Notifications\Context\Review::class);

		$this->action = new Created($this->reviewRepository, $this->upsourceUserRepository, $this->config, $this->notificationContext);
	}

	public function testProcessWhenSuccess()
	{
		$creatorId = '::creatorId::';
		$reviewId  = '::reviewId::';
		$branch    = '::branch::';

		$upsourceUserProjectId = '::projectId::';
		$upsourceUserName      = '::name::';

		$configUpsourceSiteUrl = '::upsourceUrl::';
		$configYoutrackSiteUrl = ':youtrackUrl::';

		$upsourceUser       = $this->createMock(Contract\Entity\Upsource\User::class);
		$upsourceUserRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$globalUserRecord   = $this->createMock(Contract\Record\User::class);
		$telegramUserRecord = $this->createMock(Contract\Record\Telegram\User::class);

		$upsourceUser->expects($this->once())->method('getRecord')->willReturn($upsourceUserRecord);
		$upsourceUser->expects($this->once())->method('getName')->willReturn($upsourceUserName);
		$upsourceUser->expects($this->once())->method('getProjectId')->willReturn($upsourceUserProjectId);

		$upsourceUserRecord->expects($this->once())->method('getUser')->willReturn($globalUserRecord);
		$globalUserRecord->expects($this->once())->method('getTelegram')->willReturn($telegramUserRecord);

		$this->config->expects($this->once())->method('getUpsourceUrlSite')->willReturn($configUpsourceSiteUrl);
		$this->config->expects($this->once())->method('getYoutrackUrlSite')->willReturn($configYoutrackSiteUrl);

		$this->notificationContext->expects(self::once())->method('setBranch')->with($branch);
		$this->notificationContext->expects(self::once())->method('setAuthor')->with($upsourceUserName);
		$this->notificationContext->expects(self::once())->method('setTaskLink')->with($configYoutrackSiteUrl, $branch);
		$this->notificationContext->expects(self::once())->method('setReviewLink')->with($configUpsourceSiteUrl, $upsourceUserProjectId, $reviewId);

		$telegramUserRecord->expects($this->once())
			->method('notifyAboutNewReview')
			->with($this->notificationContext);

		$this->upsourceUserRepository->expects($this->once())
			->method('getById')
			->with($creatorId)
			->willReturn($upsourceUser);
		$this->reviewRepository->expects($this->once())
			->method('create')
			->with($reviewId, $creatorId, $branch)
			->willReturn(true);

		$context = $this->createMock(Contract\Action\Upsource\Review\Context\Created::class);

		$context->expects($this->exactly(2))->method('getReviewId')->willReturn($reviewId);
		$context->expects($this->exactly(2))->method('getCreatorId')->willReturn($creatorId);
		$context->expects($this->exactly(3))->method('getBranch')->willReturn($branch);

		$this->action->process($context);
	}

	public function testProcessWhenUnknownUser(): void
	{
		$creatorId = '::creatorId::';

		$this->upsourceUserRepository->expects($this->once())
			->method('getById')
			->with($creatorId);

		$context = $this->createMock(Contract\Action\Upsource\Review\Context\Created::class);
		$context->expects($this->exactly(2))->method('getCreatorId')->willReturn($creatorId);

		$this->expectException(ExceptionWithContext::class);
		$this->expectExceptionMessage('User doesn\'t exists');

		$this->action->process($context);
	}

	public function testProcessWhenCantSaveReview(): void
	{
		$creatorId = '::creatorId::';
		$reviewId  = '::reviewId::';
		$branch    = '::branch::';

		$upsourceUser = $this->createMock(Contract\Entity\Upsource\User::class);

		$this->upsourceUserRepository->expects($this->once())
			->method('getById')
			->with($creatorId)
			->willReturn($upsourceUser);
		$this->reviewRepository->expects($this->once())
			->method('create')
			->with($reviewId, $creatorId, $branch)
			->willReturn(false);

		$context = $this->createMock(Contract\Action\Upsource\Review\Context\Created::class);

		$context->expects($this->exactly(2))->method('getReviewId')->willReturn($reviewId);
		$context->expects($this->exactly(3))->method('getCreatorId')->willReturn($creatorId);
		$context->expects($this->exactly(2))->method('getBranch')->willReturn($branch);

		$this->expectException(ExceptionWithContext::class);
		$this->expectExceptionMessage('Can\'t save review.');

		$this->action->process($context);
	}
}
