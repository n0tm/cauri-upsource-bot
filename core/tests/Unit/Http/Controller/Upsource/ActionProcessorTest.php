<?php

namespace Tests\Unit\Http\Controller\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;
use App\Http\Controllers\Upsource;
use App\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ActionProcessorTest extends TestCase
{
	use WithFaker;

    /**
     * @var Upsource\ActionProcessor|MockObject
     */
    private $actionProcessor;

	/**
	 * @var Contract\Action\ContextFactory|MockObject
	 */
    private $contextFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->contextFactory    = $this->createMock(Contract\Action\ContextFactory::class);
        $this->actionProcessor   = new Upsource\ActionProcessor($this->contextFactory);
    }

    public function testHandleWhenRequestReviewCreated(): void
    {
        $reviewCreatedRequest  = $this->createMock(Request\Upsource\Model\ReviewCreated::class);
        $reviewCreatedId       = $this->faker->text;
        $reviewCreatedBranch   = $this->faker->text;
        $reviewCreatedActorId  = $this->faker->text;

        $reviewCreatedRequest->expects($this->once())
            ->method('getReviewId')
            ->willReturn($reviewCreatedId);
        $reviewCreatedRequest->expects($this->once())
            ->method('getActorId')
            ->willReturn($reviewCreatedActorId);
	    $reviewCreatedRequest->expects($this->once())
		    ->method('getBranch')
		    ->willReturn($reviewCreatedBranch);

        $upsourceContextFactory = $this->createMock(Contract\Action\Upsource\ContextFactory::class);
        $this->contextFactory->expects($this->once())
	        ->method('createUpsource')
	        ->willReturn($upsourceContextFactory);
        $reviewCreatedContext = $this->createMock(Contract\Action\Upsource\Review\Context\Created::class);
        $upsourceContextFactory->expects($this->once())
	        ->method('createReviewCreated')
	        ->with($reviewCreatedId, $reviewCreatedActorId, $reviewCreatedBranch)
	        ->willReturn($reviewCreatedContext);

        $action = $this->createMock(Implementation\Action\Upsource\Review\Created::class);
	    $action->expects($this->once())->method('process')->with($reviewCreatedContext);

	    $this->app->instance(Implementation\Action\Upsource\Review\Created::class, $action);

        $this->actionProcessor->process($reviewCreatedRequest);
    }

	public function testHandleWhenRequestReviewClosedOrReopenedAndReviewClosed(): void
	{
		$reviewClosedOrReopenedRequest  = $this->createMock(Request\Upsource\Model\ReviewClosedOrReopened::class);
		$reviewClosedOrReopenedId       = $this->faker->text;

		$reviewClosedOrReopenedRequest->expects($this->once())
			->method('getReviewId')
			->willReturn($reviewClosedOrReopenedId);
		$reviewClosedOrReopenedRequest->expects($this->once())
			->method('isClosed')
			->willReturn(true);

		$upsourceContextFactory = $this->createMock(Contract\Action\Upsource\ContextFactory::class);
		$this->contextFactory->expects($this->once())
			->method('createUpsource')
			->willReturn($upsourceContextFactory);
		$reviewClosedOrReopenedContext = $this->createMock(Contract\Action\Upsource\Review\Context\Basic::class);
		$upsourceContextFactory->expects($this->once())
			->method('createBasic')
			->with($reviewClosedOrReopenedId)
			->willReturn($reviewClosedOrReopenedContext);

		$action = $this->createMock(Implementation\Action\Upsource\Review\Closed::class);
		$action->expects($this->once())->method('process')->with($reviewClosedOrReopenedContext);

		$this->app->instance(Implementation\Action\Upsource\Review\Closed::class, $action);

		$this->actionProcessor->process($reviewClosedOrReopenedRequest);
	}

	public function testHandleWhenRequestReviewClosedOrReopenedButReviewReopened(): void
	{
		$reviewClosedOrReopenedRequest  = $this->createMock(Request\Upsource\Model\ReviewClosedOrReopened::class);
		$reviewClosedOrReopenedRequest->expects($this->once())
			->method('isClosed')
			->willReturn(false);

		$this->expectException(Upsource\Exception\UnknownRequest::class);
		$this->expectExceptionMessage('Unknown action for provided request');

		$this->actionProcessor->process($reviewClosedOrReopenedRequest);
	}

	public function testHandleWhenDiscussionNewRequest(): void
	{
		$discussionNewRequest     = $this->createMock(Request\Upsource\Model\DiscussionNew::class);
		$discussionNewReviewId    = $this->faker->text;

		$discussionNewRequest->expects($this->once())
			->method('getReviewId')
			->willReturn($discussionNewReviewId);

		$telegramContextFactory = $this->createMock(Contract\Action\Telegram\ContextFactory::class);
		$this->contextFactory->expects($this->once())
			->method('createTelegram')
			->willReturn($telegramContextFactory);
		$deleteReviewersNotificationsAboutAllDoneDiscussionsContext = $this->createMock(Contract\Action\Telegram\Context\DeleteReviewersNotificationsAboutAllDoneDiscussions::class);
		$telegramContextFactory->expects($this->once())
			->method('createDeleteReviewersNotificationsAboutAllDoneDiscussions')
			->with($discussionNewReviewId)
			->willReturn($deleteReviewersNotificationsAboutAllDoneDiscussionsContext);

		$action = $this->createMock(Implementation\Action\Telegram\DeleteReviewersNotificationsAboutAllDoneDiscussions::class);
		$action->expects($this->once())->method('process')->with($deleteReviewersNotificationsAboutAllDoneDiscussionsContext);

		$this->app->instance(Implementation\Action\Telegram\DeleteReviewersNotificationsAboutAllDoneDiscussions::class, $action);

		$this->actionProcessor->process($discussionNewRequest);
	}

	public function testHandleWhenUnknownRequest(): void
	{
		$notExistingRequest = $this->createMock(Request\Upsource\Model\RequestInterface::class);

		$this->expectException(Upsource\Exception\UnknownRequest::class);
		$this->expectExceptionMessage('Unknown action for provided request');

		$this->actionProcessor->process($notExistingRequest);
	}
}
