<?php

namespace App\Api\Upsource\Response;

use App\Api\Upsource\Response\Object\FullUserInfo;
use App\Domain\Contract\Api\Upsource\Response\GetUserInfo;

class GetUsersInfo extends AbstractResponse implements GetUserInfo
{
	private const KEY_NAME_INFOS = 'infos';

	private const KEY_NAME_INFOS_ITEM_NAME = 'name';

	/**
	 * @inheritDoc
	 */
	public function getInfos(): array
	{
		$usersInfo = [];
		$infos = $this->getResult()[self::KEY_NAME_INFOS];
		foreach ($infos as $info) {
			$usersInfo[] = new FullUserInfo($info[self::KEY_NAME_INFOS_ITEM_NAME]);
		}

		return $usersInfo;
	}
}