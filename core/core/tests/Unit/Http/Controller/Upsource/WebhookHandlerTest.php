<?php

namespace Tests\Unit\Http\Controller\Upsource;

use App\Http\Controllers\Upsource\ActionProcessor;
use App\Http\Request\Upsource\ConverterInterface;
use App\Http\Request\Upsource\Model\RequestInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class WebhookHandlerTest extends TestCase
{
    /**
     * @var ConverterInterface|MockObject
     */
    private $converter;

    /**
     * @var ActionProcessorTest|MockObject
     */
    private $actionProcessor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actionProcessor  = $this->createMock(ActionProcessor::class);
        $this->converter        = $this->createMock(ConverterInterface::class);

        $this->app->instance(ActionProcessor::class, $this->actionProcessor);
        $this->app->instance(ConverterInterface::class, $this->converter);
    }

    public function testHandle(): void
    {
        $request = $this->createMock(RequestInterface::class);

        $this->converter->expects($this->once())
            ->method('convert')
            ->willReturn($request);
        $this->actionProcessor->expects($this->once())
            ->method('process')
            ->with($request);

        $this->post('/api/upsource', []);
    }
}