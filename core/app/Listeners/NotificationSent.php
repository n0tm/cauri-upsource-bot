<?php

namespace App\Listeners;

use App\Domain\Contract\Record\Telegram\User;
use Illuminate\Notifications\Events;
use App\Notifications;

class NotificationSent
{
	/**
	 * @var NotificationSentListener\Context\Factory
	 */
	private $contextFactory;

	public function __construct(NotificationSentListener\Context\Factory $contextFactory)
	{
		$this->contextFactory = $contextFactory;
	}

	public function handle(Events\NotificationSent $event)
    {
    	switch (true) {
		    case $event->notification instanceof Notifications\NewReview:

		    	/** @var User $notifiable */
		    	$notifiable = $event->notifiable;

		    	/** @var Notifications\NewReview $notification */
		    	$notification = $event->notification;

				$this->runListener(
					NotificationSentListener\ReviewReadyForReview::class,
					$this->contextFactory->createReviewReadyForReview(
						$event->response['result']['message_id'],
						$notifiable->getReviewChatId(),
						$notification->getContext()->getReviewId()
					)
				);

		        break;
	    }
    }

    private function runListener(string $listener, $context): void
    {
    	/** @var Listener $listener */
    	$listener = resolve($listener);
    	$listener->handle($context);
    }
}
