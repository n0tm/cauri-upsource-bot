<?php

namespace Tests\Unit\Http\Controller\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;
use App\Http\Controllers\Upsource;
use App\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ActionProcessorTest extends TestCase
{
    /**
     * @var Upsource\ActionProcessor|MockObject
     */
    private $actionProcessor;

    /**
     * @var Contract\Action\Factory|MockObject
     */
    private $actionFactory;

    /**
     * @var Contract\Repository\Factory|MockObject
     */
    private $repositoryFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actionFactory     = $this->createMock(Contract\Action\Factory::class);
        $this->repositoryFactory = $this->createMock(Contract\Repository\Factory::class);
        $this->actionProcessor   = new Upsource\ActionProcessor($this->actionFactory, $this->repositoryFactory);
    }

    public function testHandleWhenUnknownAction(): void
    {
        $notExistingRequest = $this->createMock(Request\Upsource\Model\RequestInterface::class);

        $this->expectException(Upsource\Exception\UnknownRequest::class);
        $this->expectExceptionMessage('Unknown action for provided request');

        $this->actionProcessor->process($notExistingRequest);
    }

    public function testHandleWhenReviewCreatedAction(): void
    {
        $reviewCreatedRequest  = $this->createMock(Request\Upsource\Model\ReviewCreated::class);
        $reviewCreatedId       = '::id::';
        $reviewCreatedBranch   = '::branch::';
        $reviewCreatedActorId  = '::actor id::';

        $reviewCreatedRequest->expects($this->once())
            ->method('getReviewId')
            ->willReturn($reviewCreatedId);
        $reviewCreatedRequest->expects($this->once())
            ->method('getBranch')
            ->willReturn($reviewCreatedBranch);
        $reviewCreatedRequest->expects($this->once())
            ->method('getActorId')
            ->willReturn($reviewCreatedActorId);

        $upsourceFactory = $this->createMock(Contract\Action\Upsource\Factory::class);
        $this->actionFactory->expects($this->once())
            ->method('createUpsource')
            ->willReturn($upsourceFactory);

        $upsourceRepository = $this->createMock(Implementation\Repository\Upsource\Factory::class);
        $this->repositoryFactory->expects($this->once())
            ->method('createUpsource')
            ->willReturn($upsourceRepository);
        $reviewCreatedAction  = $this->createMock(Implementation\Action\Upsource\ReviewCreated::class);
        $upsourceFactory->expects($this->once())
            ->method('createReviewCreated')
            ->with($upsourceRepository, $reviewCreatedId, $reviewCreatedBranch, $reviewCreatedActorId)
            ->willReturn($reviewCreatedAction);

        $reviewCreatedAction->expects($this->once())->method('process');

        $this->actionProcessor->process($reviewCreatedRequest);
    }

    public function testHandleWhenReviewLabelChangedAction(): void
    {
        $reviewLabelChangedRequest     = $this->createMock(Request\Upsource\Model\ReviewLabelChanged::class);
        $reviewLabelChangedReviewId    = '::id::';
        $reviewLabelChangedProjectId   = '::project id::';
        $reviewLabelChangedActorName   = '::actor name::';
        $reviewLabelChangedLabeldId    = '::label id::';
        $reviewLabelChangedIsWasAdded  = true;

        $reviewLabelChangedRequest->expects($this->once())
            ->method('getReviewId')
            ->willReturn($reviewLabelChangedReviewId);
        $reviewLabelChangedRequest->expects($this->once())
            ->method('getProjectId')
            ->willReturn($reviewLabelChangedProjectId);
        $reviewLabelChangedRequest->expects($this->once())
            ->method('getActorName')
            ->willReturn($reviewLabelChangedActorName);
        $reviewLabelChangedRequest->expects($this->once())
            ->method('getLabelId')
            ->willReturn($reviewLabelChangedLabeldId);
        $reviewLabelChangedRequest->expects($this->once())
            ->method('isWasAdded')
            ->willReturn($reviewLabelChangedIsWasAdded);

        $upsourceFactory = $this->createMock(Contract\Action\Upsource\Factory::class);
        $this->actionFactory->expects($this->once())
            ->method('createUpsource')
            ->willReturn($upsourceFactory);

        $upsourceRepository = $this->createMock(Implementation\Repository\Upsource\Factory::class);
        $this->repositoryFactory->expects($this->once())
            ->method('createUpsource')
            ->willReturn($upsourceRepository);
        $reviewCreatedAction  = $this->createMock(Implementation\Action\Upsource\ReviewLabelChanged::class);
        $upsourceFactory->expects($this->once())
            ->method('createReviewLabelChanged')
            ->with(
                $upsourceRepository,
                $reviewLabelChangedReviewId,
                $reviewLabelChangedProjectId,
                $reviewLabelChangedActorName,
                $reviewLabelChangedLabeldId,
                $reviewLabelChangedIsWasAdded
            )
            ->willReturn($reviewCreatedAction);

        $reviewCreatedAction->expects($this->once())->method('process');

        $this->actionProcessor->process($reviewLabelChangedRequest);
    }
}
