<?php

namespace App\Api\Upsource\Response\Object;

use App\Domain\Contract;

class ParticipantInReview implements Contract\Api\Upsource\Response\Object\ParticipantInReview
{
	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var int
	 */
	private $role;

	/**
	 * @var int
	 */
	private $state;

	public function __construct(string $id, int $role, int $state)
	{
		$this->id    = $id;
		$this->role  = $role;
		$this->state = $state;
	}

	public function getRole(): int
	{
		return $this->role;
	}

	public function getState(): int
	{
		return $this->state;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function isReviewer(): bool
	{
		return $this->role === Contract\Api\Upsource\Response\Object\Enum\RoleInReview::REVIEWER;
	}
}