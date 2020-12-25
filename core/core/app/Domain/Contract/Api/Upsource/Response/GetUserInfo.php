<?php

namespace App\Domain\Contract\Api\Upsource\Response;

interface GetUserInfo
{
	/**
	 * @return Object\FullUserInfo[]
	 */
	public function getInfos(): array;
}