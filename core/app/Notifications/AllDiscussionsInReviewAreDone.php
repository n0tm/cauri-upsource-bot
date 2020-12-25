<?php

namespace App\Notifications;

use App\Model;
use NotificationChannels\Telegram;
use App\Domain\Contract;

/**
 * Class AllDiscussionsInReviewAreDone
 * @package App\Notifications
 * @method setContext(Contract\Notifications\Context\Review $context) : void
 * @method Contract\Notifications\Context\Review getContext()
 */
class AllDiscussionsInReviewAreDone extends AbstractNotification
{
	public const DATABASE_KEY_NAME_REVIEW_ID = 'review_id';

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
		return [Telegram\TelegramChannel::class, self::BASE_CHANNEL_DATABASE];
	}

	public function toTelegram(Model\Telegram\User $notifiable)
	{
		$context = $this->getContext();
		$message = $this->telegramMessageFactory->createAllDiscussionsInReviewAreDone(
			$context->getBranch(),
			$context->getAuthor(),
			$context->getReviewLink(),
			$context->getTaskLink()
		);

		return $message->to($notifiable->getId());
	}

	public function toArray(Model\Telegram\User $notifiable): array
	{
		return [
			self::DATABASE_KEY_NAME_REVIEW_ID => $this->getContext()->getReviewId(),
		];
	}
}