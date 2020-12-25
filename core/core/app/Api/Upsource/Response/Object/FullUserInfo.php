<?php

namespace App\Api\Upsource\Response\Object;

class FullUserInfo implements \App\Domain\Contract\Api\Upsource\Response\Object\FullUserInfo
{
	/**
	 * @var string
	 */
	private $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}
}