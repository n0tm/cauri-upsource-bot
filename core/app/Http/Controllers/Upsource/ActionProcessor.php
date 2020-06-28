<?php

namespace App\Http\Controllers\Upsource;

use App\Domain\Contract;
use App\Http\Request\Upsource;
use Illuminate\Support\Facades\Log;

class ActionProcessor
{
    /**
     * @var Contract\Action\Factory
     */
    private $factory;

    public function __construct(Contract\Action\Factory $factory)
    {
        $this->factory = $factory;
    }

    public function process(Upsource\Model\RequestInterface $request): void
    {
        $action     = $this->getActionByRequest($request);
        $actionId   = uniqid('action-');
        $actionType = get_class($action);

        Log::info("Starting processing \"{$actionType}\" action with id:{$actionId}");
        try {
            $action->process();
        } catch (\Exception $exception) {
            Log::critical("Error occurred, during \"{$actionType}\" action processing, id:{$actionId}\n[Error Message] {$exception->getMessage()}");
        }
    }

    private function getActionByRequest(Upsource\Model\RequestInterface $request): Contract\Action\Base
    {
        switch (true) {
            case $request instanceof Upsource\Model\ReviewCreated:
                return $this->factory->createReviewCreated($request->getReviewId(), $request->getBranch());
            case $request instanceof Upsource\Model\ReviewLabelChanged:
                return $this->factory->createReviewLabelChanged($request->getReviewId(), $request->getLabelId(), $request->isWasAdded());
            default:
                throw new Exception\UnknownRequest("Unknown action for provided request");
        }
    }
}