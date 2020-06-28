<?php

namespace Tests\Unit\Http\Controller\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;
use App\Http\Controllers\Upsource\ActionProcessor;
use App\Http\Controllers\Upsource\Exception\UnknownRequest;
use App\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ActionProcessorTest extends TestCase
{
    /**
     * @var ActionProcessor|MockObject
     */
    private $actionProcessor;

    /**
     * @var Contract\Action\Factory|MockObject
     */
    private $actionFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actionFactory   = $this->createMock(Contract\Action\Factory::class);
        $this->actionProcessor = new ActionProcessor($this->actionFactory);
    }

    public function testHandleWhenUnknownAction(): void
    {
        $notExistingRequest = $this->createMock(Request\Upsource\Model\RequestInterface::class);

        $this->expectException(UnknownRequest::class);
        $this->expectExceptionMessage('Unknown action for provided request');

        $this->actionProcessor->process($notExistingRequest);
    }

    public function testHandleWhenReviewCreatedAction(): void
    {
        $reviewCreatedRequest = $this->createMock(Request\Upsource\Model\ReviewCreated::class);
        $reviewCreatedId      = '::id::';
        $reviewCreatedBranch  = '::branch::';

        $reviewCreatedRequest->expects($this->once())
            ->method('getReviewId')
            ->willReturn($reviewCreatedId);
        $reviewCreatedRequest->expects($this->once())
            ->method('getBranch')
            ->willReturn($reviewCreatedBranch);

        $reviewCreatedAction  = $this->createMock(Implementation\Action\ReviewCreated::class);
        $this->actionFactory->expects($this->once())
            ->method('createReviewCreated')
            ->with($reviewCreatedId, $reviewCreatedBranch)
            ->willReturn($reviewCreatedAction);

        $reviewCreatedAction->expects($this->once())->method('process');

        $this->actionProcessor->process($reviewCreatedRequest);
    }

    public function testHandleWhenReviewLabelChangedAction(): void
    {
        $reviewLabelChangedRequest     = $this->createMock(Request\Upsource\Model\ReviewLabelChanged::class);
        $reviewLabelChangedReviewId    = '::id::';
        $reviewLabelChangedLabeldId    = '::label id::';
        $reviewLabelChangedIsWasAdded  = true;

        $reviewLabelChangedRequest->expects($this->once())
            ->method('getReviewId')
            ->willReturn($reviewLabelChangedReviewId);
        $reviewLabelChangedRequest->expects($this->once())
            ->method('getLabelId')
            ->willReturn($reviewLabelChangedLabeldId);
        $reviewLabelChangedRequest->expects($this->once())
            ->method('isWasAdded')
            ->willReturn($reviewLabelChangedIsWasAdded);

        $reviewLabelChangedAction = $this->createMock(Implementation\Action\ReviewLabelChanged::class);
        $this->actionFactory->expects($this->once())
            ->method('createReviewLabelChanged')
            ->with($reviewLabelChangedReviewId, $reviewLabelChangedLabeldId, $reviewLabelChangedIsWasAdded)
            ->willReturn($reviewLabelChangedAction);

        $reviewLabelChangedAction->expects($this->once())->method('process');

        $this->actionProcessor->process($reviewLabelChangedRequest);
    }
}
