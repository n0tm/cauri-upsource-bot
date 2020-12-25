<?php

namespace App\Notifications\Context;

use App\Helpers;

class Review implements \App\Domain\Contract\Notifications\Context\Review
{
	/**
	 * @var string
	 */
	private $reviewLink;

	/**
	 * @var string
	 */
	private $taskLink;

	/**
	 * @var string
	 */
	public $reviewId;

	/**
	 * @var string
	 */
	private $author;

	/**
	 * @var string
	 */
	private $branch;

	/**
	 * @var Helpers\Upsource\LinkGenerator
	 */
	private $upsourceLinkGenerator;

	/**
	 * @var Helpers\Youtrack\LinkGenerator
	 */
	private $youtrackLinkGenerator;

	/**
	 * @var Helpers\Upsource\Branch
	 */
	private $upsourceBranchHelper;

	public function __construct(
		Helpers\Upsource\LinkGenerator $upsourceLinkGenerator,
		Helpers\Youtrack\LinkGenerator $youtrackLinkGenerator,
		Helpers\Upsource\Branch $upsourceBranchHelper
	) {
		$this->upsourceLinkGenerator = $upsourceLinkGenerator;
		$this->youtrackLinkGenerator = $youtrackLinkGenerator;
		$this->upsourceBranchHelper  = $upsourceBranchHelper;
	}

	public function setReviewLink(string $upsourceSiteUrl, string $projectId, string $reviewId): void
	{
		$this->reviewLink = $this->upsourceLinkGenerator->getReview($upsourceSiteUrl, $projectId, $reviewId);
	}

	public function getReviewLink(): string
	{
		return $this->reviewLink;
	}

	public function setTaskLink(string $youtrackSiteUrl, string $branch): void
	{
		$taskId = $this->upsourceBranchHelper->getTaskId($branch);
		if ($taskId !== null) {
			$this->taskLink = $this->youtrackLinkGenerator->getTask($youtrackSiteUrl, $taskId);
		}
	}

	public function getTaskLink(): ?string
	{
		return $this->taskLink;
	}

	public function setBranch(string $branch): void
	{
		$this->branch = $branch;
	}

	public function getBranch(): string
	{
		return $this->branch;
	}

	public function setAuthor(string $author): void
	{
		$this->author = $author;
	}

	public function getAuthor(): string
	{
		return $this->author;
	}

	public function setReviewId(string $id): void
	{
		$this->reviewId = $id;
	}

	public function getReviewId(): string
	{
		return $this->reviewId;
	}
}