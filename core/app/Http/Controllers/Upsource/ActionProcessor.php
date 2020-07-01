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
    private $actionFactory;

    /**
     * @var Contract\Repository\Factory
     */
    private $repositoryFactory;

    public function __construct(
        Contract\Action\Factory $actionFactory,
        Contract\Repository\Factory $repositoryFactory
    ) {
        $this->actionFactory     = $actionFactory;
        $this->repositoryFactory = $repositoryFactory;
    }

    public function process(Upsource\Model\RequestInterface $request): void
    {
        $action     = $this->getActionByRequest($request);
        $actionId   = uniqid('action-');
        $actionType = get_class($action);

        Log::info("Starting processing \"{$actionType}\" action with id:{$actionId}");
        try {
            $action->process();
        } catch (Exception $exception) {
            Log::critical("Error occurred, during \"{$actionType}\" action processing, id:{$actionId}\n[Error Message] {$exception->getMessage()}");
        } finally {
            Log::info("Action \"{$actionType}\" success, id:{$actionId}");
        }
    }

    private function getActionByRequest(Upsource\Model\RequestInterface $request): Contract\Action\Base
    {
        switch (true) {
            case $request instanceof Upsource\Model\ReviewCreated:
                return $this->actionFactory->createUpsource()->createReviewCreated(
                    $this->repositoryFactory->createUpsource(),
                    $request->getReviewId(),
                    $request->getActorId(),
                    $request->getBranch()
                );
            case $request instanceof Upsource\Model\ReviewLabelChanged:
                return $this->actionFactory->createUpsource()->createReviewLabelChanged(
                    $this->repositoryFactory->createUpsource(),
                    $request->getReviewId(),
                    $request->getProjectId(),
                    $request->getActorName(),
                    $request->getLabelId(),
                    $request->isWasAdded()
                );
            default:
                throw new Exception\UnknownRequest("Unknown action for provided request");
        }
    }
}