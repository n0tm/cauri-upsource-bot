<?php

namespace App\Http\Controllers\Upsource;

use App\Domain\Contract;
use App\Http\Controllers\Controller;
use App\Http\Request\Upsource as UpsourceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookHandler extends Controller
{
    /**
     * @var UpsourceRequest\ConverterInterface
     */
    private $requestConverter;

    /**
     * @var Contract\Action\Factory
     */
    private $actionFactory;

    public function __construct(
        UpsourceRequest\ConverterInterface $requestConverter,
        Contract\Action\Factory $actionFactory
    ) {
        $this->requestConverter = $requestConverter;
        $this->actionFactory    = $actionFactory;
    }

    public function handle(Request $request): void
    {
        $convertedRequest = $this->requestConverter->convert($request);
        $action = $this->getActionByRequest($convertedRequest);

        $actionId   = uniqid('action-');
        $actionType = get_class($action);
        Log::info("Starting processing \"{$actionType}\" action with id:{$actionId}");
        try {
            $action->process();
        } catch (\Exception $exception) {
            Log::critical("Error occurred, during \"{$actionType}\" action processing, id:{$actionId}\n[Error Message] {$exception->getMessage()}");
        }
    }

    private function getActionByRequest(UpsourceRequest\Model\RequestInterface $request): Contract\Action\Base
    {
        switch (true) {
            case $request instanceof UpsourceRequest\Model\ReviewCreated:
                return $this->actionFactory->createReviewCreated($request->getReviewId(), $request->getBranch());
            case $request instanceof UpsourceRequest\Model\ReviewLabelChanged:
                return $this->actionFactory->createReviewLabelChanged($request->getReviewId(), $request->getLabelId(), $request->isWasAdded());
            default:
                throw new Exception\UnknownRequest("Unknown action for provided request");
        }
    }
}
