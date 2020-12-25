<?php

namespace Tests\Unit\Domain\Implementation\Action\Telegram;

use App\Domain\Implementation\Action\Telegram\UpdateReviewNotificationMessage;
use App\Domain\Contract;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

/**
 * Class UpdateReviewNotificationMessageTest
 * @package Tests\Unit\Domain\Implementation\Action\Telegram
 * TODO: В данном тесте не рассмотрены ситуации при который возвращается
 * различное количество ревьюверов и предлагаемых ревьюверов
 * при попытке написания данных тестов, не получилось сделать данный кейз читаемым так, чтобы не писать под каждый кейз отдельный тест
 * Надо подумать над тем, как оттестировать данные ситуации
 */
class UpdateReviewNotificationMessageTest extends TestCase
{
	use WithFaker;

	/**
	 * @var Contract\Api\Telegram\Facade|MockObject
	 */
	private $telegramClient;

	/**
	 * @var Contract\Api\Upsource\Facade|MockObject
	 */
	private $upsourceClient;

	/**
	 * @var Contract\Repository\Upsource\Review|MockObject
	 */
	private $reviewRepository;

	/**
	 * @var Contract\Repository\Upsource\User|MockObject
	 */
	private $upsourceUserRepository;

	/**
	 * @var Contract\Notifications\Message\Component\NewReview|MockObject
	 */
	private $reviewMessage;

	/**
	 * @var UpdateReviewNotificationMessage
	 */
	private $action;

	protected function setUp(): void
	{
		parent::setUp();

		$this->telegramClient         = $this->createMock(Contract\Api\Telegram\Facade::class);
		$this->upsourceClient         = $this->createMock(Contract\Api\Upsource\Facade::class);
		$this->reviewRepository       = $this->createMock(Contract\Repository\Upsource\Review::class);
		$this->upsourceUserRepository = $this->createMock(Contract\Repository\Upsource\User::class);
		$this->reviewMessage          = $this->createMock(Contract\Notifications\Message\Component\NewReview::class);

		$this->action = new UpdateReviewNotificationMessage(
			$this->telegramClient,
			$this->upsourceClient,
			$this->reviewRepository,
			$this->upsourceUserRepository,
			$this->reviewMessage
		);
	}

	public function testProcessWhenParticipantsNotFoundInRepository()
	{
		$reviewId     = $this->faker->text;
		$reviewBranch = $this->faker->text;

		$reviewDetailsDescription = $this->faker->text;
		$reviewDetailsTotalDiscussionsCount = $this->faker->randomNumber();
		$reviewDetailsResolvedDiscussionsCount = $this->faker->randomNumber();
		$reviewDetailsIsReadyToClose = $this->faker->boolean;

		$projectId = $this->faker->text;

		$globalUserName    = $this->faker->firstName;
		$globalUserSurname = $this->faker->lastName;

		$suggestedReviewersForReviewIds = $this->faker->words;

		$telegramChatId    = $this->faker->randomNumber();
		$telegramMessageId = $this->faker->randomNumber();

		$resultReviewMessage = $this->faker->text;

		$globalUser = $this->createMock(Contract\Record\User::class);
		$globalUser->expects(self::once())->method('getName')->willReturn($globalUserName);
		$globalUser->expects(self::once())->method('getSurname')->willReturn($globalUserSurname);

		$upsourceUser = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUser->expects(self::once())->method('getUser')->willReturn($globalUser);
		$upsourceUser->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUser);

		$review = $this->createMock(Contract\Entity\Upsource\Review::class);
		$review->expects(self::once())->method('getRecord')->willReturn($reviewRecord);
		$review->expects(self::once())->method('getBranch')->willReturn($reviewBranch);
		$review->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->reviewRepository->expects(self::once())
			->method('getById')
			->with($reviewId)
			->willReturn($review);

		$reviewDetails = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetails->expects(self::once())->method('getDescription')->willReturn($reviewDetailsDescription);
		$reviewDetails->expects(self::once())->method('getDiscussionsCount')->willReturn($reviewDetailsTotalDiscussionsCount);
		$reviewDetails->expects(self::once())->method('getResolvedDiscussionsCount')->willReturn($reviewDetailsResolvedDiscussionsCount);
		$reviewDetails->expects(self::once())->method('isReadyToClose')->willReturn($reviewDetailsIsReadyToClose);

		$this->upsourceClient->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetails);

		$suggestedReviewersForReview = $this->createMock(Contract\Api\Upsource\Response\GetUsersForReview::class);
		$suggestedReviewersForReview->expects(self::once())->method('getIds')->willReturn($suggestedReviewersForReviewIds);

		$this->upsourceClient->expects(self::once())
			->method('getSuggestedReviewersForReview')
			->with($projectId, $reviewId)
			->willReturn($suggestedReviewersForReview);

		$this->reviewMessage->expects(self::once())
			->method('setTitle')
			->with(sprintf('Ревью: %s', $reviewId))
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setAuthor')
			->with(sprintf('%s %s', $globalUserName, $globalUserSurname))
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setBranch')
			->with($reviewBranch)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setDescription')
			->with($reviewDetailsDescription)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setTotalDiscussionsCount')
			->with($reviewDetailsTotalDiscussionsCount)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setResolvedDiscussionsCount')
			->with($reviewDetailsResolvedDiscussionsCount)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setIsReadyToClose')
			->with($reviewDetailsIsReadyToClose)
			->willReturn($this->reviewMessage);


		$suggestedReviewerUserName = $this->faker->firstName();
		$suggestedReviewerUserFullInfo = $this->createMock(Contract\Api\Upsource\Response\Object\FullUserInfo::class);
		$suggestedReviewerUserFullInfo->expects(self::once())
			->method('getName')
			->willReturn($suggestedReviewerUserName);

		$this->reviewMessage->method('addSuggestedReviewer')
			->with($suggestedReviewerUserName)
			->willReturn($this->reviewMessage);

		$suggestedReviewersUsersInfo = $this->createMock(Contract\Api\Upsource\Response\GetUserInfo::class);
		$suggestedReviewersUsersInfo->expects(self::once())
			->method('getInfos')
			->willReturn([$suggestedReviewerUserFullInfo]);

		$participantId = $this->faker->text;
		$participantState = $this->faker->randomNumber();
		$participant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$participant->expects(self::exactly(2))->method('getId')->willReturn($participantId);
		$participant->expects(self::once())->method('getState')->willReturn($participantState);
		$participant->expects(self::once())->method('isReviewer')->willReturn(true);

		$this->upsourceUserRepository->expects(self::once())->method('getById')->with($participantId);

		$userInfoName = $this->faker->name;
		$userInfo = $this->createMock(Contract\Api\Upsource\Response\Object\FullUserInfo::class);
		$userInfo->expects(self::once())->method('getName')->willReturn($userInfoName);

		$usersInfo = $this->createMock(Contract\Api\Upsource\Response\GetUserInfo::class);
		$usersInfo->method('getInfos')->willReturn([$userInfo]);

		$this->upsourceClient->expects(self::exactly(2))
			->method('getUsersInfo')
			->withConsecutive(
				[$suggestedReviewersForReviewIds],
				[[$participantId]]
			)
			->willReturnOnConsecutiveCalls(
				$suggestedReviewersUsersInfo,
				$usersInfo
			);

		$this->reviewMessage->method('addRecipient')
			->with($userInfoName, $participantState)
			->willReturn($this->reviewMessage);

		$this->reviewMessage->expects(self::once())
			->method('toString')
			->willReturn($resultReviewMessage);

		$reviewDetails->expects(self::once())
			->method('getParticipants')
			->willReturn([$participant]);

		$this->telegramClient->expects(self::once())
			->method('editMessageText')
			->with($telegramChatId, $telegramMessageId, $resultReviewMessage);

		$context = $this->createMock(Contract\Action\Telegram\Context\UpdateReviewNotificationMessage::class);
		$context->expects(self::exactly(3))->method('getReviewId')->willReturn($reviewId);
		$context->expects(self::once())->method('getChatId')->willReturn($telegramChatId);
		$context->expects(self::once())->method('getMessageId')->willReturn($telegramMessageId);

		$this->action->process($context);
	}

	public function testProcessWhenParticipantsFoundInRepository()
	{
		$reviewId     = $this->faker->text;
		$reviewBranch = $this->faker->text;

		$reviewDetailsDescription = $this->faker->text;
		$reviewDetailsTotalDiscussionsCount = $this->faker->randomNumber();
		$reviewDetailsResolvedDiscussionsCount = $this->faker->randomNumber();
		$reviewDetailsIsReadyToClose = $this->faker->boolean;

		$projectId = $this->faker->text;

		$globalUserName    = $this->faker->firstName;
		$globalUserSurname = $this->faker->lastName;

		$suggestedReviewersForReviewIds = $this->faker->words;

		$telegramChatId    = $this->faker->randomNumber();
		$telegramMessageId = $this->faker->randomNumber();

		$resultReviewMessage = $this->faker->text;

		$globalUser = $this->createMock(Contract\Record\User::class);
		$globalUser->expects(self::once())->method('getName')->willReturn($globalUserName);
		$globalUser->expects(self::once())->method('getSurname')->willReturn($globalUserSurname);

		$upsourceUser = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUser->expects(self::once())->method('getUser')->willReturn($globalUser);
		$upsourceUser->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUser);

		$review = $this->createMock(Contract\Entity\Upsource\Review::class);
		$review->expects(self::once())->method('getRecord')->willReturn($reviewRecord);
		$review->expects(self::once())->method('getBranch')->willReturn($reviewBranch);
		$review->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->reviewRepository->expects(self::once())
			->method('getById')
			->with($reviewId)
			->willReturn($review);

		$reviewDetails = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetails->expects(self::once())->method('getDescription')->willReturn($reviewDetailsDescription);
		$reviewDetails->expects(self::once())->method('getDiscussionsCount')->willReturn($reviewDetailsTotalDiscussionsCount);
		$reviewDetails->expects(self::once())->method('getResolvedDiscussionsCount')->willReturn($reviewDetailsResolvedDiscussionsCount);
		$reviewDetails->expects(self::once())->method('isReadyToClose')->willReturn($reviewDetailsIsReadyToClose);

		$this->upsourceClient->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetails);

		$suggestedReviewersForReview = $this->createMock(Contract\Api\Upsource\Response\GetUsersForReview::class);
		$suggestedReviewersForReview->expects(self::once())->method('getIds')->willReturn($suggestedReviewersForReviewIds);

		$this->upsourceClient->expects(self::once())
			->method('getSuggestedReviewersForReview')
			->with($projectId, $reviewId)
			->willReturn($suggestedReviewersForReview);

		$this->reviewMessage->expects(self::once())
			->method('setTitle')
			->with(sprintf('Ревью: %s', $reviewId))
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setAuthor')
			->with(sprintf('%s %s', $globalUserName, $globalUserSurname))
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setBranch')
			->with($reviewBranch)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setDescription')
			->with($reviewDetailsDescription)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setTotalDiscussionsCount')
			->with($reviewDetailsTotalDiscussionsCount)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setResolvedDiscussionsCount')
			->with($reviewDetailsResolvedDiscussionsCount)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setIsReadyToClose')
			->with($reviewDetailsIsReadyToClose)
			->willReturn($this->reviewMessage);


		$suggestedReviewerUserName = $this->faker->firstName();
		$suggestedReviewerUserFullInfo = $this->createMock(Contract\Api\Upsource\Response\Object\FullUserInfo::class);
		$suggestedReviewerUserFullInfo->expects(self::once())
			->method('getName')
			->willReturn($suggestedReviewerUserName);

		$this->reviewMessage->method('addSuggestedReviewer')
			->with($suggestedReviewerUserName)
			->willReturn($this->reviewMessage);

		$suggestedReviewersUsersInfo = $this->createMock(Contract\Api\Upsource\Response\GetUserInfo::class);
		$suggestedReviewersUsersInfo->expects(self::once())
			->method('getInfos')
			->willReturn([$suggestedReviewerUserFullInfo]);

		$participantId = $this->faker->text;
		$participantState = $this->faker->randomNumber();
		$participant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$participant->expects(self::once())->method('getId')->willReturn($participantId);
		$participant->expects(self::once())->method('getState')->willReturn($participantState);
		$participant->expects(self::once())->method('isReviewer')->willReturn(true);

		$participantFromUpsourceUserRepositoryName = $this->faker->name;
		$participantFromUpsourceUserRepository = $this->createMock(Contract\Entity\Upsource\User::class);
		$participantFromUpsourceUserRepository->expects(self::once())
			->method('getName')
			->willReturn($participantFromUpsourceUserRepositoryName);

		$this->upsourceUserRepository->expects(self::once())->method('getById')->with($participantId)->willReturn($participantFromUpsourceUserRepository);

		$this->upsourceClient->expects(self::once())
			->method('getUsersInfo')
			->with($suggestedReviewersForReviewIds)
			->willReturnOnConsecutiveCalls($suggestedReviewersUsersInfo);

		$this->reviewMessage->method('addRecipient')
			->with($participantFromUpsourceUserRepositoryName, $participantState)
			->willReturn($this->reviewMessage);

		$this->reviewMessage->expects(self::once())
			->method('toString')
			->willReturn($resultReviewMessage);

		$reviewDetails->expects(self::once())
			->method('getParticipants')
			->willReturn([$participant]);

		$this->telegramClient->expects(self::once())
			->method('editMessageText')
			->with($telegramChatId, $telegramMessageId, $resultReviewMessage);

		$context = $this->createMock(Contract\Action\Telegram\Context\UpdateReviewNotificationMessage::class);
		$context->expects(self::exactly(3))->method('getReviewId')->willReturn($reviewId);
		$context->expects(self::once())->method('getChatId')->willReturn($telegramChatId);
		$context->expects(self::once())->method('getMessageId')->willReturn($telegramMessageId);

		$this->action->process($context);
	}

	public function testProcessWhenAllParticipantsAreNotReviewers()
	{
		$reviewId     = $this->faker->text;
		$reviewBranch = $this->faker->text;

		$reviewDetailsDescription = $this->faker->text;
		$reviewDetailsTotalDiscussionsCount = $this->faker->randomNumber();
		$reviewDetailsResolvedDiscussionsCount = $this->faker->randomNumber();
		$reviewDetailsIsReadyToClose = $this->faker->boolean;

		$projectId = $this->faker->text;

		$globalUserName    = $this->faker->firstName;
		$globalUserSurname = $this->faker->lastName;

		$suggestedReviewersForReviewIds = $this->faker->words;

		$telegramChatId    = $this->faker->randomNumber();
		$telegramMessageId = $this->faker->randomNumber();

		$resultReviewMessage = $this->faker->text;

		$globalUser = $this->createMock(Contract\Record\User::class);
		$globalUser->expects(self::once())->method('getName')->willReturn($globalUserName);
		$globalUser->expects(self::once())->method('getSurname')->willReturn($globalUserSurname);

		$upsourceUser = $this->createMock(Contract\Record\Upsource\User::class);
		$upsourceUser->expects(self::once())->method('getUser')->willReturn($globalUser);
		$upsourceUser->expects(self::once())->method('getProjectId')->willReturn($projectId);

		$reviewRecord = $this->createMock(Contract\Record\Upsource\Review::class);
		$reviewRecord->expects(self::once())->method('getUpsourceUser')->willReturn($upsourceUser);

		$review = $this->createMock(Contract\Entity\Upsource\Review::class);
		$review->expects(self::once())->method('getRecord')->willReturn($reviewRecord);
		$review->expects(self::once())->method('getBranch')->willReturn($reviewBranch);
		$review->expects(self::once())->method('getId')->willReturn($reviewId);

		$this->reviewRepository->expects(self::once())
			->method('getById')
			->with($reviewId)
			->willReturn($review);

		$reviewDetails = $this->createMock(Contract\Api\Upsource\Response\GetReviewDetails::class);
		$reviewDetails->expects(self::once())->method('getDescription')->willReturn($reviewDetailsDescription);
		$reviewDetails->expects(self::once())->method('getDiscussionsCount')->willReturn($reviewDetailsTotalDiscussionsCount);
		$reviewDetails->expects(self::once())->method('getResolvedDiscussionsCount')->willReturn($reviewDetailsResolvedDiscussionsCount);
		$reviewDetails->expects(self::once())->method('isReadyToClose')->willReturn($reviewDetailsIsReadyToClose);

		$this->upsourceClient->expects(self::once())
			->method('getReviewDetails')
			->with($projectId, $reviewId)
			->willReturn($reviewDetails);

		$suggestedReviewersForReview = $this->createMock(Contract\Api\Upsource\Response\GetUsersForReview::class);
		$suggestedReviewersForReview->expects(self::once())->method('getIds')->willReturn($suggestedReviewersForReviewIds);

		$this->upsourceClient->expects(self::once())
			->method('getSuggestedReviewersForReview')
			->with($projectId, $reviewId)
			->willReturn($suggestedReviewersForReview);

		$this->reviewMessage->expects(self::once())
			->method('setTitle')
			->with(sprintf('Ревью: %s', $reviewId))
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setAuthor')
			->with(sprintf('%s %s', $globalUserName, $globalUserSurname))
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setBranch')
			->with($reviewBranch)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setDescription')
			->with($reviewDetailsDescription)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setTotalDiscussionsCount')
			->with($reviewDetailsTotalDiscussionsCount)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setResolvedDiscussionsCount')
			->with($reviewDetailsResolvedDiscussionsCount)
			->willReturn($this->reviewMessage);
		$this->reviewMessage->expects(self::once())
			->method('setIsReadyToClose')
			->with($reviewDetailsIsReadyToClose)
			->willReturn($this->reviewMessage);


		$suggestedReviewerUserName = $this->faker->firstName();
		$suggestedReviewerUserFullInfo = $this->createMock(Contract\Api\Upsource\Response\Object\FullUserInfo::class);
		$suggestedReviewerUserFullInfo->expects(self::once())
			->method('getName')
			->willReturn($suggestedReviewerUserName);

		$this->reviewMessage->method('addSuggestedReviewer')
			->with($suggestedReviewerUserName)
			->willReturn($this->reviewMessage);

		$suggestedReviewersUsersInfo = $this->createMock(Contract\Api\Upsource\Response\GetUserInfo::class);
		$suggestedReviewersUsersInfo->expects(self::once())
			->method('getInfos')
			->willReturn([$suggestedReviewerUserFullInfo]);

		$participantId = $this->faker->text;
		$participant = $this->createMock(Contract\Api\Upsource\Response\Object\ParticipantInReview::class);
		$participant->expects(self::once())->method('isReviewer')->willReturn(false);

		$this->upsourceUserRepository->expects(self::never())->method('getById')->with($participantId);

		$this->upsourceClient->expects(self::once())
			->method('getUsersInfo')
			->with($suggestedReviewersForReviewIds)
			->willReturnOnConsecutiveCalls($suggestedReviewersUsersInfo);

		$this->reviewMessage->expects(self::once())
			->method('toString')
			->willReturn($resultReviewMessage);

		$reviewDetails->expects(self::once())
			->method('getParticipants')
			->willReturn([$participant]);

		$this->telegramClient->expects(self::once())
			->method('editMessageText')
			->with($telegramChatId, $telegramMessageId, $resultReviewMessage);

		$context = $this->createMock(Contract\Action\Telegram\Context\UpdateReviewNotificationMessage::class);
		$context->expects(self::exactly(3))->method('getReviewId')->willReturn($reviewId);
		$context->expects(self::once())->method('getChatId')->willReturn($telegramChatId);
		$context->expects(self::once())->method('getMessageId')->willReturn($telegramMessageId);

		$this->action->process($context);
	}
}
