<?php

namespace App\Api\Upsource\Request;

use App\Common\ArrayConvertible;

class GetUsersInfo implements ArrayConvertible
{
	private const KEY_IDS = 'ids';

	/**
	 * @var string[]
	 */
	private $ids;

	public function __construct(array $ids)
	{
		$this->ids = $ids;
	}

	public function convertToArray(): array
	{
		return [
			self::KEY_IDS => $this->ids
		];
	}
}