<?php

namespace App\Notifications\Message;

use NotificationChannels\Telegram\TelegramMessage;

class TelegramFactory extends AbstractFactory
{
	/**
	 * @var Component\Factory
	 */
	private $componentFactory;

	public function __construct(Component\Factory $componentFactory)
	{
		$this->componentFactory = $componentFactory;
	}

	public function createNewReview(string $reviewLink, string $author, string $branch, ?string $taskLink = null): TelegramMessage
	{
		$message = $this->getPreparedBasicMessage()->button('Ревью', $reviewLink);
		$content = $this->componentFactory->createReview()
			->setTitle('Пользователь создал ревью')
			->setAuthor($author)
			->setBranch($branch)
			->toString();

		$taskLink !== null
			? $message->button('Задача', $taskLink)
			: $content .= "\n\nНе удалось найти задачу привязанную к ветке";

		return $message->content($content);
	}

	public function createAllDiscussionsInReviewAreDone(string $branch, string $author, string $reviewLink, ?string $taskLink = null): TelegramMessage
	{
		$message = $this->getPreparedBasicMessage()->button('Ревью', $reviewLink);
		$content = $this->componentFactory->createAllDiscussionsInReviewAreDone()
			->setBranch($branch)
			->setAuthor($author)
			->toString();

		$taskLink !== null
			? $message->button('Задача', $taskLink)
			: $content .= "\n\nНе удалось найти задачу привязанную к ветке";

		return $message->content($content);
	}

	private function getPreparedBasicMessage(): TelegramMessage
	{
		return $this->getBasic()->options(['parse_mode' => 'HTML']);
	}

	/**
	 * @return TelegramMessage
	 */
	protected function getBasic()
	{
		return new TelegramMessage();
	}
}