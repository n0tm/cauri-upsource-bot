<?php

namespace App\Notifications\Message\Component;

use App\Domain\Contract;

class NewReview implements Contract\Notifications\Message\Component\NewReview
{
	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $author;

	/**
	 * @var string
	 */
	private $branch;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var int
	 */
	private $totalDiscussionsCount;

	/**
	 * @var int
	 */
	private $resolvedDiscussionsCount;

	/**
	 * @var bool
	 */
	private $isReadyToClose = false;

	/**
	 * @var Object\ReviewRecipient[]
	 */
	private $recipients = [];

	/**
	 * @var string[]
	 */
	private $suggestedReviewers = [];

	public function setTitle(string $title): Contract\Notifications\Message\Component\NewReview
	{
		$this->title = $title;
		return $this;
	}

	public function setAuthor(string $author): Contract\Notifications\Message\Component\Review
	{
		$this->author = $author;
		return $this;
	}

	public function setBranch(string $branch): Contract\Notifications\Message\Component\Review

	{
		$this->branch = $branch;
		return $this;
	}

	public function setDescription(string $description): Contract\Notifications\Message\Component\NewReview
	{
		$this->description = $description;
		return $this;
	}

	public function setTotalDiscussionsCount(int $totalDiscussionsCount): Contract\Notifications\Message\Component\NewReview
	{
		$this->totalDiscussionsCount = $totalDiscussionsCount;
		return $this;
	}

	public function setResolvedDiscussionsCount(int $resolvedDiscussionsCount): Contract\Notifications\Message\Component\NewReview
	{
		$this->resolvedDiscussionsCount = $resolvedDiscussionsCount;
		return $this;
	}

	public function setIsReadyToClose(bool $isReadyToClose): Contract\Notifications\Message\Component\NewReview
	{
		$this->isReadyToClose = $isReadyToClose;
		return $this;
	}

	public function addRecipient(string $name, int $state): Contract\Notifications\Message\Component\NewReview
	{
		$this->recipients[] = new Object\ReviewRecipient($name, $state);
		return $this;
	}

	public function addSuggestedReviewer(string $suggestedReviewer): Contract\Notifications\Message\Component\NewReview
	{
		$this->suggestedReviewers[] = $suggestedReviewer;
		return $this;
	}

	public function toString(): string
	{
		return $this->__toString();
	}

	public function __toString()
	{
		$result = sprintf(
			"%s\n👨‍💻 %s\n〽️ %s\n\n🗒 %s\n\n💬 %s/%s\n\n",
			$this->title ?? '',
			$this->author ?? 'Нет автора',
			$this->branch ?? 'Нет ветки',
			$this->description ?? 'Нет описания',
			$this->totalDiscussionsCount ?? 0,
			$this->resolvedDiscussionsCount ?? 0
		);

		foreach ($this->recipients as $recipient) {
			$result .= sprintf("👁‍🗨 %s\n", $recipient);
		}

		if (!empty($this->suggestedReviewers)) {
			$result .= "Предлагаемые ревьюверы:\n";
			foreach ($this->suggestedReviewers as $suggestedReviewer) {
				$result .= sprintf("%s\n", $suggestedReviewer);
			}
		}

		$result .= $this->isReadyToClose ? 'Можно закрывать' : 'Нужно добить';

		return $result;
	}
}