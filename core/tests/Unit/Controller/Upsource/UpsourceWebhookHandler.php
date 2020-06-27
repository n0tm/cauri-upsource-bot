<?php

namespace Tests\Unit\Controller\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;
use App\Http\Controllers\Upsource\Exception\UnknownRequest;
use App\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class UpsourceWebhookHandler extends TestCase
{
    /**
     * @var Contract\Processor|MockObject
     */
    private $actionProcessor;

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

        $this->actionProcessor  = $this->createMock(Contract\Processor::class);
        $this->requestConverter = $this->createMock(Request\Upsource\ConverterInterface::class);
        $this->actionFactory    = $this->createMock(Contract\Action\Factory::class);

        $this->app->instance(Contract\Processor::class, $this->actionProcessor);
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

    public function testHandleWhenNewReviewAction(): void
    {
        $newReviewRequest = $this->createMock(Request\Upsource\Model\NewReview::class);
        $newReviewId      = '::id::';
        $newReviewBranch  = '::branch::';

        $newReviewRequest->expects($this->once())
            ->method('getReviewId')
            ->willReturn($newReviewId);
        $newReviewRequest->expects($this->once())
            ->method('getBranch')
            ->willReturn($newReviewBranch);

        $this->requestConverter->expects($this->once())
            ->method('convert')
            ->willReturn($newReviewRequest);

        $newReviewAction = $this->createMock(Implementation\Action\NewReview::class);
        $this->actionFactory->expects($this->once())
            ->method('createNewReview')
            ->with($newReviewId, $newReviewBranch)
            ->willReturn($newReviewAction);

        $this->actionProcessor->expects($this->once())
            ->method('process')
            ->with($newReviewAction);

        $this->post('/api/upsource', []);
    }
}
