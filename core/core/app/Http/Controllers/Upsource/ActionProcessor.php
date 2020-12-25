<?php

namespace App\Http\Controllers\Upsource;

use App\Domain\Contract;
use App\Domain\Implementation;
use App\Http\Request\Upsource;
use Illuminate\Support\Facades\Log;

class ActionProcessor
{
	/**
	 * @var Contract\Action\ContextFactory
	 */
    private $contextFactory;

    public function __construct(Contract\Action\ContextFactory $contextFactory)
    {
        $this->contextFactory = $contextFactory;
    }

    public function process(Upsource\Model\RequestInterface $request): void
    {
	    switch (true) {
		    case $request instanceof Upsource\Model\ReviewCreated:
			    $context = $this->contextFactory->createUpsource()->createReviewCreated(
			    	$request->getReviewId(),
			    	$request->getActorId(),
				    $request->getBranch()
			    );

			    /** @var Implementation\Action\Upsource\Review\Created $action */
			    $action = resolve(Implementation\Action\Upsource\Review\Created::class);
			    break;
		    case ($request instanceof Upsource\Model\ReviewClosedOrReopened && $request->isClosed()):
				$context = $this->contextFactory->createUpsource()->createBasic($request->getReviewId());

				/** @var Implementation\Action\Upsource\Review\Closed $action */
				$action = resolve(Implementation\Action\Upsource\Review\Closed::class);
				break;
		    case $request instanceof Upsource\Model\DiscussionNew:
		    	$context = $this->contextFactory->createTelegram()
				    ->createDeleteReviewersNotificationsAboutAllDoneDiscussions($request->getReviewId());

		    	/** @var Implementation\Action\Telegram\DeleteReviewersNotificationsAboutAllDoneDiscussions $action */
		    	$action = resolve(Implementation\Action\Telegram\DeleteReviewersNotificationsAboutAllDoneDiscussions::class);
		    	break;
		    default:
			    throw new Exception\UnknownRequest("Unknown action for provided request");
	    }

	    $actionId   = uniqid('action-');
	    $actionType = get_class($action);

        Log::info("Starting processing \"{$actionType}\" action with id:{$actionId}");
        try {
            $action->process($context);
        } catch (\Exception $exception) {
            Log::critical("Error occurred, during \"{$actionType}\" action processing, id:{$actionId}\n[Error Message] {$exception->getMessage()}");
        } finally {
            Log::info("Action \"{$actionType}\" success, id:{$actionId}");
        }
    }
}