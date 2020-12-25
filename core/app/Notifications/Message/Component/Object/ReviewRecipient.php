<?php

namespace App\Notifications\Message\Component\Object;

class ReviewRecipient
{
	public const REVIEWER_STATE_UNREAD   = 1;
	public const REVIEWER_STATE_READ     = 2;
	public const REVIEWER_STATE_ACCEPTED = 3;
	public const REVIEWER_STATE_REJECTED = 4;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var int
	 */
	private $state;

	public function __construct(string $name, int $state)
	{
		$this->name  = $name;
		$this->state = $state;
	}

	public function __toString()
	{
		return sprintf('%s %s', $this->name, $this->convertStateToEmoji($this->state));
	}

	private function convertStateToEmoji(int $state): string
	{
		switch ($state) {
			case self::REVIEWER_STATE_UNREAD:
				return '💤';
			case self::REVIEWER_STATE_READ:
				return '👀';
			case self::REVIEWER_STATE_ACCEPTED:
				return '✅';
			case self::REVIEWER_STATE_REJECTED:
				return '❌';
			default:
				return '❔';
		}
	}
}