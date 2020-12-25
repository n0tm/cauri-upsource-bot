<?php

namespace App\Api\Upsource\Response;

class GetUsersForReview extends AbstractResponse implements \App\Domain\Contract\Api\Upsource\Response\GetUsersForReview
{
	private const KEY_NAME_RESULT = 'result';
	private const KEY_NAME_OTHERS = 'others';

	public function getIds(): array
	{
		return $this->getResult()[self::KEY_NAME_RESULT][self::KEY_NAME_OTHERS];
	}
}