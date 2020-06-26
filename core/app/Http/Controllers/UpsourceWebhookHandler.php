<?php

namespace App\Http\Controllers;

use App\Domain\Contract;
use App\Http\Request\Upsource as UpsourceRequest;
use Illuminate\Http\Request;

class UpsourceWebhookHandler extends Controller
{
    /**
     * @var Contract\Processor
     */
    private $actionProcessor;

    /**
     * @var UpsourceRequest\Converter
     */
    private $requestConverter;

    public function __construct(Contract\Processor $actionProcessor, UpsourceRequest\Converter $requestConverter)
    {
        $this->actionProcessor  = $actionProcessor;
        $this->requestConverter = $requestConverter;
    }

    public function handle(Request $request): void
    {
        $convertedRequest = $this->requestConverter->convert($request);
        $action = $this->getActionByRequest($convertedRequest);
        $this->actionProcessor->process($action);
    }

    private function getActionByRequest(UpsourceRequest\RequestInterface $request): Contract\Action\AbstractAction
    {
        return;
    }
}
