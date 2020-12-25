<?php

namespace App\Domain\Contract\Api\Upsource\Response\Object;

interface ParticipantInReview
{
	public function getId(): string;
	public function getRole(): int;
	public function getState(): int;
	public function isReviewer(): bool;
}