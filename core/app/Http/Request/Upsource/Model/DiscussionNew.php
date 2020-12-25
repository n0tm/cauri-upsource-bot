<?php

namespace App\Http\Request\Upsource\Model;

class DiscussionNew extends AbstractRequest
{
	private const KEY_NAME_BASE      = 'base';
	private const KEY_NAME_REVIEW_ID = 'reviewId';

	public function getReviewId(): string
	{
		return $this->getData()[self::KEY_NAME_BASE][self::KEY_NAME_REVIEW_ID];
	}
}