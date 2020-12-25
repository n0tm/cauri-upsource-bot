<?php

namespace App\Notifications;

use App\Model;
use Illuminate\Bus\Queueable;
use NotificationChannels\Telegram;
use App\Domain\Contract;

/**
 * Class NewReview
 * @package App\Notifications
 * @method setContext(Contract\Notifications\Context\Review $context) : void
 * @method Contract\Notifications\Context\Review getContext()
 */
class NewReview extends AbstractNotification
{
    use Queueable;

	/**
	 * @var Message\TelegramFactory
	 */
	private $telegramMessageFactory;

    public function __construct(Message\TelegramFactory $telegramMessageFactory)
    {
    	$this->telegramMessageFactory = $telegramMessageFactory;
    }

    public function via()
    {
        return [Telegram\TelegramChannel::class];
    }

    public function toTelegram(Model\Telegram\User $notifiable)
    {
    	$message = $this->telegramMessageFactory->createNewReview(
    		$this->getContext()->getReviewLink(),
		    $this->getContext()->getAuthor(),
		    $this->getContext()->getBranch(),
		    $this->getContext()->getTaskLink()
	    );

    	return $message->to($notifiable->getReviewChatId());
    }
}
