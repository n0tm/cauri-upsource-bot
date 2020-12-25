<?php

namespace App\Api\Upsource\Response;

abstract class AbstractResponse
{
	private const KEY_NAME_RESULT = 'result';

	/**
	 * @var array
	 */
	protected $data;

	public function __construct(array $data)
	{
		$this->data = $data;
	}

	protected function getResult(): array
	{
		return $this->data[self::KEY_NAME_RESULT];
	}
}