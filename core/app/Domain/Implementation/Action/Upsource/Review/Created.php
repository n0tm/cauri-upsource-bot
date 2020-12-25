<?php

namespace App\Domain\Implementation\Action\Upsource\Review;

use App\Common\ExceptionWithContext;
use App\Domain\Contract;

class Created implements Contract\Action\Basic
{
	/**
	 * @var Contract\Repository\Upsource\User
	 */
	private $upsourceUserRepository;

	/**
	 * @var Contract\System\Facade
	 */
	private $config;

	/**
	 * @var Contract\Repository\Upsource\Review
	 */
	private $reviewRepository;

	/**
	 * @var Contract\Notifications\Context\Review
	 */
	private $notificationContext;

	public function __construct(
		Contract\Repository\Upsource\Review $reviewRepository,
		Contract\Repository\Upsource\User $upsourceUserRepository,
		Contract\System\Facade $config,
		Contract\Notifications\Context\Review $notificationContext
	) {
		$this->reviewRepository       = $reviewRepository;
		$this->upsourceUserRepository = $upsourceUserRepository;
		$this->config                 = $config;
		$this->notificationContext    = $notificationContext;
	}

	/**
	 * @param Contract\Action\Upsource\Review\Context\Created $context
	 */
    public function process($context): void
    {
        $upsourceUser = $this->upsourceUserRepository->getById($context->getCreatorId());
        if ($upsourceUser === null) {
        	$exception = new ExceptionWithContext('User doesn\'t exists');
        	$exception->setContext(['creatorId' => $context->getCreatorId()]);
        	throw $exception;
        }

        $isSuccessfullySaved = $this->reviewRepository->create(
		    $context->getReviewId(),
		    $context->getCreatorId(),
		    $context->getBranch()
	    );

        if (!$isSuccessfullySaved) {
        	$exception = new ExceptionWithContext('Can\'t save review.');
        	$exception->setContext([
        		'reviewId'  => $context->getReviewId(),
		        'creatorId' => $context->getCreatorId(),
		        'branch'    => $context->getBranch(),
            ]);

        	throw $exception;
        }

        $this->notificationContext->setBranch($context->getBranch());
        $this->notificationContext->setAuthor($upsourceUser->getName());
	    $this->notificationContext->setTaskLink($this->config->getYoutrackUrlSite(), $context->getBranch());
	    $this->notificationContext->setReviewLink(
        	$this->config->getUpsourceUrlSite(),
	        $upsourceUser->getProjectId(),
	        $context->getReviewId()
        );

        $telegramUser = $upsourceUser->getRecord()->getUser()->getTelegram();
	    $telegramUser->notifyAboutNewReview($this->notificationContext);
    }
}