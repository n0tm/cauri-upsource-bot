<?php

namespace App\Domain\Contract\Notifications\Context;

interface Review
{
	public function setReviewId(string $id): void;
	public function getReviewId(): string;

	public function setReviewLink(string $upsourceSiteUrl, string $projectId, string $reviewId): void;
	public function getReviewLink(): string;

	public function setTaskLink(string $youtrackSiteUrl, string $branch): void;
	public function getTaskLink(): ?string;

	public function setBranch(string $branch): void;
	public function getBranch(): string;

	public function getAuthor(): string;
	public function setAuthor(string $author): void;
}