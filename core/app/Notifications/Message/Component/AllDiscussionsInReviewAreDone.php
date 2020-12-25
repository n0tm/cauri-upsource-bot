<?php

namespace App\Notifications\Message\Component;

use App\Domain\Contract;

class AllDiscussionsInReviewAreDone implements Contract\Notifications\Message\Component\Review
{
	/**
	 * @var string
	 */
	private $branch;

	/**
	 * @var string
	 */
	private $author;

	public function setBranch(string $branch): Contract\Notifications\Message\Component\Review
	{
		$this->branch = $branch;
		return $this;
	}

	public function setAuthor(string $author): Contract\Notifications\Message\Component\Review
	{
		$this->author = $author;
		return $this;
	}

	public function toString(): string
	{
		return $this->__toString();
	}

	public function __toString(): string
	{
		return sprintf("Пользователь закрыл все комментарии в ревью\n\n👨‍💻 %s\n〽️ %s", $this->author, $this->branch);
	}
}