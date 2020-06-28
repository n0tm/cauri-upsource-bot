<?php

namespace Tests\Unit\Http\Controller\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;
use App\Http\Controllers\Upsource\Exception\UnknownRequest;
use App\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class UpsourceWebhookHandlerTest extends TestCase
{
    /**
     * @var Request\Upsource\ConverterInterface|MockObject
     */
    private $requestConverter;

    /**
     * @var Contract\Action\Factory|MockObject
     */
    private $actionFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestConverter = $this->createMock(Request\Upsource\ConverterInterface::class);
        $this->actionFactory    = $this->createMock(Contract\Action\Factory::class);

        $this->app->instance(Contract\Action\Factory::class, $this->actionFactory);
        $this->app->instance(Request\Upsource\ConverterInterface::class, $this->requestConverter);
    }

    public function testHandleWhenUnknownAction(): void
    {
        $notExistingRequest = $this->createMock(Request\Upsource\Model\RequestInterface::class);
        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->willReturn($notExistingRequest);

        $this->expectException(UnknownRequest::class);
        $this->expectExceptionMessage('Unknown action for provided request');

        $this->post('/api/upsource', []);
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

        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->willReturn($reviewCreatedRequest);

        $reviewCreatedAction = $this->createMock(Implementation\Action\ReviewCreated::class);
        $this->actionFactory->expects($this->once())
            ->method('createReviewCreated')
            ->with($reviewCreatedId, $reviewCreatedBranch)
            ->willReturn($reviewCreatedAction);

        $reviewCreatedAction->expects($this->once())
            ->method('process');

        $this->post('/api/upsource', []);
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

        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->willReturn($reviewLabelChangedRequest);

        $reviewLabelChangedAction = $this->createMock(Implementation\Action\ReviewLabelChanged::class);
        $this->actionFactory->expects($this->once())
            ->method('createReviewLabelChanged')
            ->with($reviewLabelChangedReviewId, $reviewLabelChangedLabeldId, $reviewLabelChangedIsWasAdded)
            ->willReturn($reviewLabelChangedAction);

        $reviewLabelChangedAction->expects($this->once())
            ->method('process');

        $this->post('/api/upsource', []);
    }
}
