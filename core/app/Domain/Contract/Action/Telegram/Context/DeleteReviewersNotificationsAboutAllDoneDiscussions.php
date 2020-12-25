<?php

namespace App\Domain\Contract\Action\Telegram\Context;

interface DeleteReviewersNotificationsAboutAllDoneDiscussions
{
	public function getReviewId(): string;
}