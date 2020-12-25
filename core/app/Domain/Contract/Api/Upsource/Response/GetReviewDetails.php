<?php

namespace App\Domain\Contract\Api\Upsource\Response;

use App\Api\Upsource\Response\Object\ParticipantInReview;

interface GetReviewDetails
{
	public function getDiscussionsCount(): int;
	public function getResolvedDiscussionsCount(): int;
	public function getDescription(): ?string;
	public function isReadyToClose(): bool;
	public function isOpen(): bool;

	/**
	 * @return ParticipantInReview[]
	 */
	public function getParticipants(): array;
}