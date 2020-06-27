<?php

namespace App\Http\Controllers\Upsource;

use App\Domain\Contract;
use App\Http\Controllers\Controller;
use App\Http\Request\Upsource as UpsourceRequest;
use Illuminate\Http\Request;

class WebhookHandler extends Controller
{
    /**
     * @var Contract\Processor
     */
    private $actionProcessor;

    /**
     * @var UpsourceRequest\ConverterInterface
     */
    private $requestConverter;

    /**
     * @var Contract\Action\Factory
     */
    private $actionFactory;

    public function __construct(
        Contract\Processor $actionProcessor,
        UpsourceRequest\ConverterInterface $requestConverter,
        Contract\Action\Factory $actionFactory
    ) {
        $this->actionProcessor  = $actionProcessor;
        $this->requestConverter = $requestConverter;
        $this->actionFactory = $actionFactory;
    }

    public function handle(Request $request): void
    {
        $convertedRequest = $this->requestConverter->convert($request);
        $action = $this->getActionByRequest($convertedRequest);
        $this->actionProcessor->process($action);
    }

    private function getActionByRequest(UpsourceRequest\Model\RequestInterface $request): Contract\Action\AbstractAction
    {
        switch (true) {
            case $request instanceof UpsourceRequest\Model\NewReview:
                return $this->actionFactory->createNewReview($request->getReviewId(), $request->getBranch());
            default:
                throw new Exception\UnknownRequest("Unknown action for provided request");
        }
    }
}
