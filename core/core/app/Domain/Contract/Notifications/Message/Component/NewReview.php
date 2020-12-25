<?php

namespace App\Domain\Contract\Notifications\Message\Component;

interface NewReview extends Review
{
	public function setTitle(string $title): self;
	public function setDescription(string $description): self;
	public function setTotalDiscussionsCount(int $totalDiscussionsCount): self;
	public function setResolvedDiscussionsCount(int $resolvedDiscussionsCount): self;
	public function setIsReadyToClose(bool $isReadyToClose): self;
	public function addRecipient(string $name, int $state): self;
	public function addSuggestedReviewer(string $suggestedReviewer): self;
}