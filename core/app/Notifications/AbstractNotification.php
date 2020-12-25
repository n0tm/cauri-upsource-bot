<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

/**
 * Class AbstractNotification
 * @package App\Notifications
 * @method array toArray($notifiable)
 */
abstract class AbstractNotification extends Notification
{
	public const BASE_CHANNEL_DATABASE = 'database';

	/**
	 * @var mixed
	 */
	private $context;

	public function setContext($context): void
	{
		$this->context = $context;
	}

	public function getContext()
	{
		return $this->context;
	}
}