<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram;

use App\Domain\Implementation\Action\Telegram\NotifyReviewersAboutAllDoneDiscussions;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use App\Domain\Contract;


class NotifyReviewersAboutAllDoneDiscussionsTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Api\Upsource\Facade|MockObject
	 */
	private $apiUpsource;

	/**
	 * @var Contract\Repository\Notifications|MockObject
	 */
	private $notificationsRepository;

	/**
	 * @var Contract\Notifications\Context\Review|MockObject
	 */
	private $notificationContext;

	/**
	 * @var Contract\Repository\Upsource\User|MockObject
	 */
	private $upsourceUserRepository;

	/**
	 * @var Contract\System\Facade|MockObject
	 */
	private $config;

	/**
	 * @var NotifyReviewersAboutAllDoneDiscussions
	 */
	private $action;

	private $actionContext;

	protected function setUp(): void
	{
		parent::setUp();

		$this->apiUpsource             = $this->createMock(Contract\Api\Upsource\Facade::class);
		$this->notificationsRepository = $this->createMock(Contract\Repository\Notifications::class);
		$this->upsourceUserRepository  = $this->createMock(Contract\Repository\Upsource\User::class);
		$this->notificationContext     = $this->createMock(Contract\Notifications\Context\Review::class);
		$this->config                  = $this->createMock(Contract\System\Facade::class);

		$this->action = new NotifyReviewersAboutAllDoneDiscussions(
			$this->apiUpsource,
			$this->notificationsRepository,
			$this->upsourceUserRepository,
			$this->notificationContext,
			$this->config
		);

		$this->actionContext = $this->createMock(Contract\Action\Telegram\Context\NotifyReviewersAboutAllDoneDiscussions::class);
	}

	public function testProcessWhenNotAllWithLabelDone(): void
	{
		$projectId = $this->faker->text();
		$reviewId  = $this->faker->text();

		$upsourceUserRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserRecord->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUserRecord);
		$reviewRecord->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->actionContext->expects(self::once())->method('getReview')->willReturn($reviewRecord);

		$reviewSummaryDiscussionsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewSummaryDiscussions::class);
		$reviewSummaryDiscussionsResponse->expects(self::once())->method('isAllWithLabelDone')->willReturn(false);

		$this->apiUpsource->expects(self::once())
			->method('getReviewSummaryDiscussions')
			->with($projectId, $reviewId)
			->willReturn($reviewSummaryDiscussionsResponse);
		$this->apiUpsource->expects(self::never())->method('getReviewDetails');

		$this->action->process($this->actionContext);
	}

	public function testProcessWhenReviewersNotExist(): void
	{
		$projectId = $this->faker->text();
		$reviewId  = $this->faker->text();

		$upsourceUserRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserRecord->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUserRecord);
		$reviewRecord->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->actionContext->expects(self::once())->method('getReview')->willReturn($reviewRecord);

		$reviewSummaryDiscussionsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewSummaryDiscussions::class);
		$reviewSummaryDiscussionsResponse->expects(self::once())
			->method('isAllWithLabelDone')
			->willReturn(true);

		$this->apiUpsource->expects(self::once())
			->method('getReviewSummaryDiscussions')
			->with($projectId, $reviewId)
			->willReturn($reviewSummaryDiscussionsResponse);

		$reviewParticipant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$reviewParticipant->expects(self::once())->method('isReviewer')->willReturn(false);

		$reviewDetailsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetailsResponse->expects(self::once())->method('getParticipants')->willReturn([$reviewParticipant]);

		$this->apiUpsource->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetailsResponse);

		$this->upsourceUserRepository->expects(self::never())->method('getById');

		$this->action->process($this->actionContext);
	}

	public function testProcessWhenReviewerNotExistInUpsourceRepository(): void
	{
		$projectId = $this->faker->text();
		$reviewId  = $this->faker->text();

		$upsourceUserRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserRecord->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUserRecord);
		$reviewRecord->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->actionContext->expects(self::once())->method('getReview')->willReturn($reviewRecord);

		$reviewSummaryDiscussionsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewSummaryDiscussions::class);
		$reviewSummaryDiscussionsResponse->expects(self::once())
			->method('isAllWithLabelDone')
			->willReturn(true);

		$this->apiUpsource->expects(self::once())
			->method('getReviewSummaryDiscussions')
			->with($projectId, $reviewId)
			->willReturn($reviewSummaryDiscussionsResponse);

		$reviewParticipant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$reviewParticipant->expects(self::once())->method('isReviewer')->willReturn(true);

		$reviewDetailsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetailsResponse->expects(self::once())->method('getParticipants')->willReturn([$reviewParticipant]);

		$this->apiUpsource->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetailsResponse);

		$this->upsourceUserRepository->expects(self::once())->method('getById');
		$this->notificationsRepository->expects(self::never())
			->method('isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists');

		$this->action->process($this->actionContext);
	}

	public function testProcessWhenReviewerWasAlreadyNotified(): void
	{
		$projectId = $this->faker->text();
		$reviewId  = $this->faker->text();

		$upsourceUserRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserRecord->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUserRecord);
		$reviewRecord->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->actionContext->expects(self::once())->method('getReview')->willReturn($reviewRecord);

		$reviewSummaryDiscussionsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewSummaryDiscussions::class);
		$reviewSummaryDiscussionsResponse->expects(self::once())
			->method('isAllWithLabelDone')
			->willReturn(true);

		$this->apiUpsource->expects(self::once())
			->method('getReviewSummaryDiscussions')
			->with($projectId, $reviewId)
			->willReturn($reviewSummaryDiscussionsResponse);

		$reviewParticipant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$reviewParticipant->expects(self::once())->method('isReviewer')->willReturn(true);

		$reviewDetailsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetailsResponse->expects(self::once())->method('getParticipants')->willReturn([$reviewParticipant]);

		$this->apiUpsource->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetailsResponse);

		$telegramUser = $this->createMock(Contract\Record\Telegram\User::class);
		$globalUserRecord = $this->createMock(Contract\Record\User::class);
		$globalUserRecord->expects(self::once())
			->method('getTelegram')
			->willReturn($telegramUser);

		$upsourceUserFromRepositoryRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserFromRepositoryRecord->expects(self::once())
			->method('getUser')
			->willReturn($globalUserRecord);

		$upsourceUserFromRepositoryEntity = $this->createMock(Contract\Entity\Upsource\User::class);
		$upsourceUserFromRepositoryEntity->expects(self::once())
			->method('getRecord')
			->willReturn($upsourceUserFromRepositoryRecord);

		$this->upsourceUserRepository->expects(self::once())->method('getById')->willReturn($upsourceUserFromRepositoryEntity);

		$this->notificationsRepository->expects(self::once())
			->method('isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists')
			->with($telegramUser, $reviewId)
			->willReturn(true);

		$telegramUser->expects(self::never())->method('notifyAboutAllDoneDiscussions');

		$this->action->process($this->actionContext);
	}

	public function testProcessWhenSuccess(): void
	{
		$projectId = $this->faker->text();
		$reviewId  = $this->faker->text();

		$upsourceUserRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserRecord->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUserRecord);
		$reviewRecord->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->actionContext->expects(self::once())->method('getReview')->willReturn($reviewRecord);

		$reviewSummaryDiscussionsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewSummaryDiscussions::class);
		$reviewSummaryDiscussionsResponse->expects(self::once())
			->method('isAllWithLabelDone')
			->willReturn(true);

		$this->apiUpsource->expects(self::once())
			->method('getReviewSummaryDiscussions')
			->with($projectId, $reviewId)
			->willReturn($reviewSummaryDiscussionsResponse);

		$reviewParticipant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$reviewParticipant->expects(self::once())->method('isReviewer')->willReturn(true);

		$reviewDetailsResponse = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetailsResponse->expects(self::once())->method('getParticipants')->willReturn([$reviewParticipant]);

		$this->apiUpsource->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetailsResponse);

		$telegramUser = $this->createMock(Contract\Record\Telegram\User::class);
		$globalUserRecord = $this->createMock(Contract\Record\User::class);
		$globalUserRecord->expects(self::once())
			->method('getTelegram')
			->willReturn($telegramUser);

		$upsourceUserFromRepositoryRecord = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUserFromRepositoryRecord->expects(self::once())
			->method('getUser')
			->willReturn($globalUserRecord);

		$upsourceUserFromRepositoryEntity = $this->createMock(Contract\Entity\Upsource\User::class);
		$upsourceUserFromRepositoryEntity->expects(self::once())
			->method('getRecord')
			->willReturn($upsourceUserFromRepositoryRecord);

		$this->upsourceUserRepository->expects(self::once())->method('getById')->willReturn($upsourceUserFromRepositoryEntity);

		$this->notificationsRepository->expects(self::once())
			->method('isTelegramUserNotificationAboutAllDoneDiscussionsInReviewExists')
			->with($telegramUser, $reviewId)
			->willReturn(false);

		$reviewBranch = $this->faker->text();
		$reviewRecord->expects(self::once())->method('getBranch')->willReturn($reviewBranch);

		$author = $this->faker->firstName();
		$upsourceUserFromRepositoryEntity->expects(self::once())->method('getName')->willReturn($author);
		$this->notificationContext->expects(self::once())->method('setAuthor')->with($author);
		$this->notificationContext->expects(self::once())->method('setBranch')->with($reviewBranch);
		$this->notificationContext->expects(self::once())->method('setReviewId')->with($reviewId);

		$youtrackUrlSite = $this->faker->url;
		$this->config->expects(self::once())->method('getYoutrackUrlSite')->willReturn($youtrackUrlSite);
		$this->notificationContext->expects(self::once())->method('setTaskLink')->with($youtrackUrlSite, $reviewBranch);

		$upsourceUrlSite = $this->faker->url;
		$this->config->expects(self::once())->method('getUpsourceUrlSite')->willReturn($upsourceUrlSite);
		$this->notificationContext->expects(self::once())->method('setReviewLink')->with($upsourceUrlSite, $projectId, $reviewId);

		$telegramUser->expects(self::once())
			->method('notifyAboutAllDoneDiscussions')
			->with($this->notificationContext);

		$this->action->process($this->actionContext);
	}

}
