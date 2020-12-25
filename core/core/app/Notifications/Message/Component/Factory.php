<?php

namespace App\Notifications\Message\Component;

class Factory
{
	public function createReview(): NewReview
	{
		return new NewReview();
	}

	public function createAllDiscussionsInReviewAreDone(): AllDiscussionsInReviewAreDone
	{
		return new AllDiscussionsInReviewAreDone();
	}
}